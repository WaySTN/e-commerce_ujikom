<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ensure sample customers exist
        $customer1 = User::firstOrCreate(
            ['email' => 'customer@example.com'],
            [
                'name' => 'Budi Customer',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        $customer2 = User::firstOrCreate(
            ['email' => 'siti.rahma@example.com'],
            [
                'name' => 'Siti Rahmawati',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        $customer3 = User::firstOrCreate(
            ['email' => 'andi.wijaya@example.com'],
            [
                'name' => 'Andi Wijaya',
                'password' => Hash::make('password'),
                'role' => 'customer',
            ]
        );

        $products = Product::all();
        if ($products->isEmpty()) {
            return;
        }

        $sampleOrders = [
            [
                'user' => $customer1,
                'days_ago' => 12,
                'status' => 'selesai',
                'payment_method' => 'transfer',
                'payment_status' => 'lunas',
                'address' => "Jl. Merdeka No. 45, RT 02/RW 05\nKel. Gambir, Kec. Gambir, Jakarta Pusat 10110",
                'notes' => 'Tolong bubble wrap yang tebal ya kak.',
                'items' => [
                    ['product' => $products->get(0) ?? $products->first(), 'qty' => 1],
                    ['product' => $products->get(1) ?? $products->first(), 'qty' => 2],
                ],
            ],
            [
                'user' => $customer2,
                'days_ago' => 10,
                'status' => 'selesai',
                'payment_method' => 'cod',
                'payment_status' => 'lunas',
                'address' => "Komplek Graha Indah Blok C2 No. 12\nKec. Sukasari, Kota Bandung 40152",
                'notes' => 'Antar sebelum jam 5 sore.',
                'items' => [
                    ['product' => $products->get(2) ?? $products->first(), 'qty' => 1],
                ],
            ],
            [
                'user' => $customer3,
                'days_ago' => 8,
                'status' => 'selesai',
                'payment_method' => 'transfer',
                'payment_status' => 'lunas',
                'address' => "Perumahan Griya Asri Blok D No. 8\nKec. Lowokwaru, Kota Malang 65141",
                'notes' => null,
                'items' => [
                    ['product' => $products->get(4) ?? $products->first(), 'qty' => 1],
                    ['product' => $products->get(3) ?? $products->first(), 'qty' => 2],
                ],
            ],
            [
                'user' => $customer1,
                'days_ago' => 6,
                'status' => 'selesai',
                'payment_method' => 'transfer',
                'payment_status' => 'lunas',
                'address' => "Jl. Merdeka No. 45, RT 02/RW 05\nKel. Gambir, Kec. Gambir, Jakarta Pusat 10110",
                'notes' => 'Warna hitam kalau ada.',
                'items' => [
                    ['product' => $products->get(5) ?? $products->first(), 'qty' => 1],
                    ['product' => $products->get(6) ?? $products->first(), 'qty' => 2],
                ],
            ],
            [
                'user' => $customer2,
                'days_ago' => 4,
                'status' => 'selesai',
                'payment_method' => 'transfer',
                'payment_status' => 'lunas',
                'address' => "Komplek Graha Indah Blok C2 No. 12\nKec. Sukasari, Kota Bandung 40152",
                'notes' => null,
                'items' => [
                    ['product' => $products->get(0) ?? $products->first(), 'qty' => 2],
                ],
            ],
            [
                'user' => $customer3,
                'days_ago' => 3,
                'status' => 'dikirim',
                'payment_method' => 'transfer',
                'payment_status' => 'lunas',
                'address' => "Perumahan Griya Asri Blok D No. 8\nKec. Lowokwaru, Kota Malang 65141",
                'notes' => 'Nomor resi mohon diupdate.',
                'items' => [
                    ['product' => $products->get(2) ?? $products->first(), 'qty' => 1],
                    ['product' => $products->get(1) ?? $products->first(), 'qty' => 1],
                ],
            ],
            [
                'user' => $customer1,
                'days_ago' => 2,
                'status' => 'diproses',
                'payment_method' => 'transfer',
                'payment_status' => 'lunas',
                'address' => "Jl. Merdeka No. 45, RT 02/RW 05\nKel. Gambir, Kec. Gambir, Jakarta Pusat 10110",
                'notes' => null,
                'items' => [
                    ['product' => $products->get(4) ?? $products->first(), 'qty' => 1],
                ],
            ],
            [
                'user' => $customer2,
                'days_ago' => 1,
                'status' => 'diproses',
                'payment_method' => 'cod',
                'payment_status' => 'menunggu',
                'address' => "Komplek Graha Indah Blok C2 No. 12\nKec. Sukasari, Kota Bandung 40152",
                'notes' => 'Siapkan uang pas saat kurir datang.',
                'items' => [
                    ['product' => $products->get(6) ?? $products->first(), 'qty' => 3],
                    ['product' => $products->get(7) ?? $products->first(), 'qty' => 1],
                ],
            ],
            [
                'user' => $customer3,
                'days_ago' => 0,
                'status' => 'pending',
                'payment_method' => 'transfer',
                'payment_status' => 'menunggu',
                'address' => "Perumahan Griya Asri Blok D No. 8\nKec. Lowokwaru, Kota Malang 65141",
                'notes' => 'Akan transfer sore nanti via m-banking.',
                'items' => [
                    ['product' => $products->get(0) ?? $products->first(), 'qty' => 1],
                    ['product' => $products->get(5) ?? $products->first(), 'qty' => 1],
                ],
            ],
            [
                'user' => $customer1,
                'days_ago' => 5,
                'status' => 'dibatalkan',
                'payment_method' => 'transfer',
                'payment_status' => 'ditolak',
                'address' => "Jl. Merdeka No. 45, RT 02/RW 05\nKel. Gambir, Jakarta Pusat",
                'notes' => 'Salah pesan varian produk.',
                'items' => [
                    ['product' => $products->get(3) ?? $products->first(), 'qty' => 1],
                ],
            ],
        ];

        foreach ($sampleOrders as $index => $data) {
            $orderDate = now()->subDays($data['days_ago'])->setHour(rand(9, 19))->setMinute(rand(10, 50));
            $dateStr = $orderDate->format('Ymd');
            $orderNumber = 'INV-' . $dateStr . '-' . str_pad($index + 1, 4, '0', STR_PAD_LEFT);

            // Calculate total price
            $totalPrice = 0;
            foreach ($data['items'] as $it) {
                if ($it['product']) {
                    $totalPrice += $it['product']->price * $it['qty'];
                }
            }

            $order = Order::updateOrCreate(
                ['order_number' => $orderNumber],
                [
                    'user_id' => $data['user']->id,
                    'total_price' => $totalPrice,
                    'shipping_address' => $data['address'],
                    'notes' => $data['notes'],
                    'status' => $data['status'],
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]
            );

            // Order Items
            foreach ($data['items'] as $it) {
                if ($it['product']) {
                    $subtotal = $it['product']->price * $it['qty'];
                    OrderItem::updateOrCreate(
                        [
                            'order_id' => $order->id,
                            'product_id' => $it['product']->id,
                        ],
                        [
                            'product_name' => $it['product']->name,
                            'price' => $it['product']->price,
                            'qty' => $it['qty'],
                            'subtotal' => $subtotal,
                            'created_at' => $orderDate,
                            'updated_at' => $orderDate,
                        ]
                    );
                }
            }

            // Payment
            Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'method' => $data['payment_method'],
                    'status' => $data['payment_status'],
                    'paid_at' => $data['payment_status'] === 'lunas' ? $orderDate : null,
                    'created_at' => $orderDate,
                    'updated_at' => $orderDate,
                ]
            );
        }
    }
}
