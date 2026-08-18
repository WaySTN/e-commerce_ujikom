<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected $seed = true;

    public function test_customer_can_checkout_and_product_stock_is_decremented(): void
    {
        $customer = User::where('role', 'customer')->first() ?? User::factory()->create(['role' => 'customer']);
        $product = Product::first();
        $initialStock = $product->stock;

        // 1. Add to cart in session
        $this->actingAs($customer)
            ->withSession([
                'cart' => [
                    $product->id => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'price' => $product->price,
                        'qty' => 2,
                        'image' => $product->image,
                        'stock' => $product->stock,
                    ],
                ],
            ])
            ->post(route('checkout.store'), [
                'shipping_address' => 'Jl. Pengujian No. 123',
                'notes' => 'Catatan test checkout',
                'payment_method' => 'transfer',
            ])
            ->assertRedirect();

        // 2. Verify order created
        $this->assertDatabaseHas('orders', [
            'user_id' => $customer->id,
            'shipping_address' => 'Jl. Pengujian No. 123',
            'status' => 'pending',
        ]);

        // 3. Verify stock decremented
        $product->refresh();
        $this->assertEquals($initialStock - 2, $product->stock);

        // 4. Verify payment created
        $order = Order::where('user_id', $customer->id)->latest()->first();
        $this->assertNotNull($order->payment);
        $this->assertEquals('transfer', $order->payment->method);
        $this->assertEquals('menunggu', $order->payment->status);
    }

    public function test_admin_cancelling_order_restores_product_stock(): void
    {
        $admin = User::where('role', 'admin')->first();
        $customer = User::where('role', 'customer')->first();
        $product = Product::first();

        $initialStock = $product->stock;

        // Create an active pending order with 3 units of product
        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'INV-TEST-CANCEL-001',
            'total_price' => $product->price * 3,
            'shipping_address' => 'Alamat cancel',
            'status' => 'pending',
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'price' => $product->price,
            'qty' => 3,
            'subtotal' => $product->price * 3,
        ]);

        // Simulate stock already deducted when order was made
        $product->decrement('stock', 3);
        $this->assertEquals($initialStock - 3, $product->fresh()->stock);

        // Admin cancels the order
        $this->actingAs($admin)
            ->patch(route('admin.pesanan.update-status', $order->id), [
                'status' => 'dibatalkan',
            ])
            ->assertRedirect();

        // Verify order status is dibatalkan
        $this->assertEquals('dibatalkan', $order->fresh()->status);

        // Verify stock has been restored (+3)
        $this->assertEquals($initialStock, $product->fresh()->stock);
    }

    public function test_admin_completing_cod_order_automatically_marks_payment_lunas(): void
    {
        $admin = User::where('role', 'admin')->first();
        $customer = User::where('role', 'customer')->first();
        $product = Product::first();

        // Create COD order
        $order = Order::create([
            'user_id' => $customer->id,
            'order_number' => 'INV-TEST-COD-001',
            'total_price' => $product->price,
            'shipping_address' => 'Alamat COD',
            'status' => 'diproses',
        ]);

        $payment = Payment::create([
            'order_id' => $order->id,
            'method' => 'cod',
            'status' => 'menunggu',
        ]);

        // Admin completes the order (kurir berhasil kirim & terima uang)
        $this->actingAs($admin)
            ->patch(route('admin.pesanan.update-status', $order->id), [
                'status' => 'selesai',
            ])
            ->assertRedirect();

        $payment->refresh();
        $this->assertEquals('lunas', $payment->status);
        $this->assertNotNull($payment->paid_at);
    }

    public function test_customer_cannot_view_other_customers_order(): void
    {
        $customerA = User::where('role', 'customer')->first();
        $customerB = User::factory()->create(['role' => 'customer']);

        $orderA = Order::where('user_id', $customerA->id)->first();
        if (! $orderA) {
            $orderA = Order::create([
                'user_id' => $customerA->id,
                'order_number' => 'INV-TEST-AUTH-001',
                'total_price' => 100000,
                'shipping_address' => 'Alamat A',
                'status' => 'pending',
            ]);
        }

        // Customer B tries to view Customer A's order
        $response = $this->actingAs($customerB)->get(route('orders.show', $orderA->id));
        $response->assertStatus(403);
    }

    public function test_admin_can_access_sales_report_with_date_filters(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.laporan.index', [
            'start_date' => now()->subDays(7)->toDateString(),
            'end_date' => now()->toDateString(),
        ]));

        $response->assertStatus(200);
        $response->assertSee('Laporan Penjualan Toko');
        $response->assertSee('Total Pendapatan Lunas');
    }
}
