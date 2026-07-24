<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CartController extends Controller
{
    private function saveCart(array $cart)
    {
        session()->put('cart', $cart);
        if (auth()->check()) {
            Cache::forever('user_cart_' . auth()->id(), $cart);
        }
    }

    public function index()
    {
        $cart = session()->get('cart', []);

        // Restore cart from cache for logged-in user if session cart is empty
        if (empty($cart) && auth()->check()) {
            $cachedCart = Cache::get('user_cart_' . auth()->id(), []);
            if (! empty($cachedCart)) {
                $cart = $cachedCart;
                session()->put('cart', $cart);
            }
        } elseif (! empty($cart) && auth()->check()) {
            Cache::forever('user_cart_' . auth()->id(), $cart);
        }

        $total = array_reduce($cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0);

        return view('cart.index', compact('cart', 'total'));
    }

    public function store(Request $request, Product $product)
    {
        if (! $product->is_active || $product->stock < 1) {
            return back()->with('error', 'Stok produk tidak mencukupi atau produk tidak aktif.');
        }

        $cart = session()->get('cart', []);

        // Restore cached cart if session cart is empty
        if (empty($cart) && auth()->check()) {
            $cart = Cache::get('user_cart_' . auth()->id(), []);
        }

        $qty = (int) $request->input('qty', 1);

        if (isset($cart[$product->id])) {
            $newQty = $cart[$product->id]['qty'] + $qty;
            if ($newQty > $product->stock) {
                return back()->with('error', 'Jumlah pesanan melebihi stok yang tersedia.');
            }
            $cart[$product->id]['qty'] = $newQty;
        } else {
            if ($qty > $product->stock) {
                return back()->with('error', 'Jumlah pesanan melebihi stok yang tersedia.');
            }
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'price' => $product->price,
                'qty' => $qty,
                'image' => $product->image,
                'stock' => $product->stock,
            ];
        }

        $this->saveCart($cart);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'qty' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($request->qty > $product->stock) {
                return back()->with('error', 'Jumlah pesanan melebihi stok produk (' . $product->stock . ').');
            }

            $cart[$product->id]['qty'] = (int) $request->qty;
            $this->saveCart($cart);

            return back()->with('success', 'Jumlah produk berhasil diperbarui.');
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }

    public function destroy(Product $product)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            $this->saveCart($cart);
            return back()->with('success', 'Produk berhasil dihapus dari keranjang.');
        }

        return back()->with('error', 'Produk tidak ditemukan di keranjang.');
    }
}
