<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = $request->user()->orders()
            ->with(['items', 'payment'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        $order->load(['items.product', 'payment']);

        return view('orders.show', compact('order'));
    }

    public function uploadBuktiBayar(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        if (! $order->payment || $order->payment->method !== 'transfer') {
            return back()->with('error', 'Metode pembayaran pesanan ini bukan Transfer Bank.');
        }

        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ], [
            'proof_image.required' => 'Pilih file bukti transfer terlebih dahulu.',
            'proof_image.image' => 'File harus berupa gambar.',
            'proof_image.mimes' => 'Format gambar harus JPEG, JPG, atau PNG.',
            'proof_image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        if ($order->payment->proof_image) {
            Storage::disk('public')->delete($order->payment->proof_image);
        }

        $path = $request->file('proof_image')->store('payment_proofs', 'public');

        $order->payment->update([
            'proof_image' => $path,
            'status' => 'menunggu',
        ]);

        return back()->with('success', 'Bukti pembayaran berhasil diunggah dan sedang menunggu verifikasi admin.');
    }
}
