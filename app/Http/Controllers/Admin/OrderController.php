<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

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

        $previousStatus = $order->status;
        $newStatus = $request->status;

        DB::transaction(function () use ($order, $previousStatus, $newStatus) {
            $order->update([
                'status' => $newStatus,
            ]);

            // If order is cancelled, restore stock for all products in this order
            if ($newStatus === 'dibatalkan' && $previousStatus !== 'dibatalkan') {
                $order->load('items.product');
                foreach ($order->items as $item) {
                    if ($item->product) {
                        $item->product->increment('stock', $item->qty);
                    }
                }
            }

            // If order is finished (selesai) and payment is COD (Cash on Delivery), auto-mark payment as lunas
            if ($newStatus === 'selesai') {
                $payment = $order->payment;
                if ($payment && $payment->method === 'cod' && $payment->status === 'menunggu') {
                    $payment->update([
                        'status' => 'lunas',
                        'paid_at' => now(),
                    ]);
                }
            }
        });

        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi "' . $newStatus . '".');
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
