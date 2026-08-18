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
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->toDateString());

        $ordersQuery = Order::with(['user', 'payment'])
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate);

        $orders = (clone $ordersQuery)->latest()->get();

        $totalTransactions = $orders->count();
        $totalRevenue = (clone $ordersQuery)->whereHas('payment', function ($q) {
            $q->where('status', 'lunas');
        })->sum('total_price');

        // Top selling products
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->whereHas('order', function ($q) use ($startDate, $endDate) {
                $q->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            })
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Prepare daily chart data for the selected date range
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        $chartLabels = [];
        $chartRevenues = [];
        $chartOrderCounts = [];

        $diffInDays = $start->diffInDays($end);
        if ($diffInDays <= 60) {
            $current = $start->copy();
            while ($current->lte($end)) {
                $dateStr = $current->toDateString();
                $chartLabels[] = $current->translatedFormat('d M');

                $dayRev = Order::whereDate('created_at', $dateStr)
                    ->whereHas('payment', fn($q) => $q->where('status', 'lunas'))
                    ->sum('total_price');
                $chartRevenues[] = (float) $dayRev;

                $dayCount = Order::whereDate('created_at', $dateStr)->count();
                $chartOrderCounts[] = $dayCount;

                $current->addDay();
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
            'chartOrderCounts'
        ));
    }
}
