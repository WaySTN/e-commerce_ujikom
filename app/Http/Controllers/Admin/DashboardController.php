<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Order::count();
        $totalRevenue = Payment::where('status', 'lunas')
            ->join('orders', 'payments.order_id', '=', 'orders.id')
            ->sum('orders.total_price');
        $pendingOrders = Order::where('status', 'pending')->count();
        $totalProducts = Product::count();

        $recentOrders = Order::with(['user', 'payment'])->latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'totalProducts',
            'recentOrders'
        ));
    }
}
