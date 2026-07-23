<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0);

        return view('checkout.index', compact('cart', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:transfer,cod',
        ], [
            'shipping_address.required' => 'Alamat pengiriman wajib diisi.',
            'payment_method.required' => 'Pilih metode pembayaran.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        // Validate stock for all items
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (! $product || ! $product->is_active || $product->stock < $item['qty']) {
                return redirect()->route('cart.index')->with('error', 'Stok produk "' . $item['name'] . '" tidak mencukupi untuk diproses.');
            }
        }

        $order = DB::transaction(function () use ($request, $cart) {
            $totalPrice = array_reduce($cart, function ($carry, $item) {
                return $carry + ($item['price'] * $item['qty']);
            }, 0);

            // Generate order_number INV-YYYYMMDD-XXXX
            $dateStr = now()->format('Ymd');
            $todayOrderCount = Order::whereDate('created_at', now()->today())->count() + 1;
            $orderNumber = 'INV-' . $dateStr . '-' . str_pad($todayOrderCount, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => $orderNumber,
                'total_price' => $totalPrice,
                'shipping_address' => $request->shipping_address,
                'notes' => $request->notes,
                'status' => 'pending',
            ]);

            foreach ($cart as $item) {
                $subtotal = $item['price'] * $item['qty'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'subtotal' => $subtotal,
                ]);

                // Reduce stock
                Product::where('id', $item['id'])->decrement('stock', $item['qty']);
            }

            Payment::create([
                'order_id' => $order->id,
                'method' => $request->payment_method,
                'status' => 'menunggu',
            ]);

            session()->forget('cart');

            return $order;
        });

        return redirect()->route('orders.show', $order->id)->with('success', 'Pesanan berhasil dibuat! Silakan cek instruksi pembayaran.');
    }
}
