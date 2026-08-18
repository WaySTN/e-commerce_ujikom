<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();

        // Total Revenue (Lunas)
        $totalRevenue = Payment::where('payments.status', 'lunas')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->sum('orders.total_price');

        // Revenue Current Month
        $revenueThisMonth = Payment::where('payments.status', 'lunas')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->whereMonth('orders.created_at', now()->month)
            ->whereYear('orders.created_at', now()->year)
            ->sum('orders.total_price');

        $pendingOrders = Order::where('status', 'pending')->count();
        $pendingPayments = Payment::where('status', 'menunggu')->count();
        $totalProducts = Product::count();

        // Low stock products (stok <= 5)
        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 5)
            ->orderBy('stock', 'asc')
            ->get();

        // Order Status Counts Breakdown
        $orderStatuses = ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'];
        $orderStatusCounts = [];
        foreach ($orderStatuses as $st) {
            $orderStatusCounts[$st] = Order::where('status', $st)->count();
        }

        // Payment Status Counts Breakdown
        $paymentStatuses = ['menunggu', 'lunas', 'ditolak'];
        $paymentStatusCounts = [];
        foreach ($paymentStatuses as $pst) {
            $paymentStatusCounts[$pst] = Payment::where('status', $pst)->count();
        }

        // Top 5 Selling Products
        $topProducts = OrderItem::select('product_name', DB::raw('SUM(qty) as total_qty'), DB::raw('SUM(subtotal) as total_sales'))
            ->groupBy('product_name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        // Recent Orders
        $recentOrders = Order::with(['user', 'payment'])->latest()->take(5)->get();

        // 7-Day Revenue & Order Trend Data for Chart.js
        $chartDates = [];
        $chartRevenues = [];
        $chartOrderCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $displayDate = now()->subDays($i)->translatedFormat('d M');
            $chartDates[] = $displayDate;

            $dailyRev = Payment::where('payments.status', 'lunas')
                ->join('orders', 'payments.order_id', '=', 'orders.id')
                ->whereDate('orders.created_at', $date)
                ->sum('orders.total_price');
            $chartRevenues[] = (float) $dailyRev;

            $dailyCount = Order::whereDate('created_at', $date)->count();
            $chartOrderCounts[] = $dailyCount;
        }

        // Category Sales Distribution for Doughnut Chart
        $categorySales = DB::table('categories')
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->select('categories.name', DB::raw('COALESCE(SUM(order_items.qty), 0) as total_sold'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_sold')
            ->get();

        return view('admin.dashboard.index', compact(
            'totalOrders',
            'totalRevenue',
            'revenueThisMonth',
            'pendingOrders',
            'pendingPayments',
            'totalProducts',
            'lowStockProducts',
            'orderStatusCounts',
            'paymentStatusCounts',
            'topProducts',
            'recentOrders',
            'chartDates',
            'chartRevenues',
            'chartOrderCounts',
            'categorySales'
        ));
    }
}
