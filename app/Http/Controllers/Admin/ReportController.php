<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $rawStartDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $rawEndDate = $request->input('end_date', now()->toDateString());

        // Parse and validate date parameters safely
        try {
            $start = \Carbon\Carbon::parse($rawStartDate)->startOfDay();
            $end = \Carbon\Carbon::parse($rawEndDate)->endOfDay();
        } catch (\Exception $e) {
            $start = now()->startOfMonth()->startOfDay();
            $end = now()->endOfDay();
        }

        // Swap dates if start is greater than end
        if ($start->gt($end)) {
            $temp = $start;
            $start = $end->copy()->startOfDay();
            $end = $temp->copy()->endOfDay();
        }

        $startDate = $start->toDateString();
        $endDate = $end->toDateString();

        $ordersQuery = Order::with(['user', 'payment'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        $orders = (clone $ordersQuery)->latest()->get();

        $totalTransactions = $orders->count();
        $totalRevenue = (clone $ordersQuery)->whereHas('payment', function ($q) {
            $q->where('status', 'lunas');
        })->sum('total_price');

        // Top selling products in date range
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            })
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Generate Chart Data Dynamically for ANY range (Daily if <= 60 days, Monthly if > 60 days)
        $chartLabels = [];
        $chartRevenues = [];
        $chartOrderCounts = [];
        $diffInDays = $start->diffInDays($end);

        if ($diffInDays <= 60) {
            $chartPeriodType = 'harian';
            $ordersByDate = $orders->groupBy(fn($order) => $order->created_at->toDateString());

            $current = $start->copy()->startOfDay();
            while ($current->lte($end)) {
                $dateStr = $current->toDateString();
                $chartLabels[] = $current->translatedFormat('d M');

                $dayOrders = $ordersByDate->get($dateStr, collect());
                $chartOrderCounts[] = $dayOrders->count();

                $dayRev = $dayOrders->filter(fn($o) => $o->payment && $o->payment->status === 'lunas')
                    ->sum('total_price');
                $chartRevenues[] = (float) $dayRev;

                $current->addDay();
            }
        } else {
            $chartPeriodType = 'bulanan';
            $ordersByMonth = $orders->groupBy(fn($order) => $order->created_at->format('Y-m'));

            $current = $start->copy()->startOfMonth();
            $endMonth = $end->copy()->startOfMonth();
            while ($current->lte($endMonth)) {
                $ymStr = $current->format('Y-m');
                $chartLabels[] = $current->translatedFormat('M Y');

                $monthOrders = $ordersByMonth->get($ymStr, collect());
                $chartOrderCounts[] = $monthOrders->count();

                $monthRev = $monthOrders->filter(fn($o) => $o->payment && $o->payment->status === 'lunas')
                    ->sum('total_price');
                $chartRevenues[] = (float) $monthRev;

                $current->addMonth();
            }
        }

        return view('admin.reports.index', compact(
            'orders',
            'startDate',
            'endDate',
            'totalTransactions',
            'totalRevenue',
            'topProducts',
            'chartLabels',
            'chartRevenues',
            'chartOrderCounts',
            'chartPeriodType'
        ));
    }
}
