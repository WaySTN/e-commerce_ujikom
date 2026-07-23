<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->whereHas('payment', function ($q) use ($request) {
                $q->where('status', $request->payment_status);
            });
        }

        $orders = $query->latest()->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'payment']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (in_array($order->status, ['selesai', 'dibatalkan'])) {
            return back()->with('error', 'Status pesanan yang sudah "' . $order->status . '" tidak dapat diubah lagi.');
        }

        $request->validate([
            'status' => 'required|in:pending,diproses,dikirim,selesai,dibatalkan',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi "' . $request->status . '".');
    }

    public function verifikasiPembayaran(Request $request, Order $order)
    {
        $request->validate([
            'payment_status' => 'required|in:lunas,ditolak',
        ]);

        if (! $order->payment) {
            return back()->with('error', 'Data pembayaran tidak ditemukan.');
        }

        $order->payment->update([
            'status' => $request->payment_status,
            'paid_at' => $request->payment_status === 'lunas' ? now() : null,
        ]);

        return back()->with('success', 'Status pembayaran berhasil diperbarui menjadi "' . $request->payment_status . '".');
    }
}
