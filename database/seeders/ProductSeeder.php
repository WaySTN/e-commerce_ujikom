<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $casingCat = Category::where('slug', 'casing-pelindung')->first();
        $chargerCat = Category::where('slug', 'kabel-charger')->first();
        $audioCat = Category::where('slug', 'audio-earphone')->first();
        $powerbankCat = Category::where('slug', 'powerbank-storage')->first();

        $products = [
            [
                'category_id' => $chargerCat?->id,
                'name' => 'Charger GaN Fast Charging 65W Triple Port USB-C & USB-A',
                'description' => 'Adapter charger cepat teknologi GaN 65 Watt dengan 2 port Type-C dan 1 port USB-A. Kompatibel untuk laptop, smartphone Android, dan iPhone.',
                'price' => 250000,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'category_id' => $chargerCat?->id,
                'name' => 'Kabel Data Type-C to Lightning Braided Fast Charge 2 Meter',
                'description' => 'Kabel data anyaman nilon tahan tekukan hingga 10.000 kali. Mendukung PD Fast Charge 20W untuk iPhone dan iPad.',
                'price' => 85000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'category_id' => $audioCat?->id,
                'name' => 'TWS Earbuds Noise Cancelling Bluetooth 5.3 Waterproof IPX5',
                'description' => 'Headset nirkabel dengan suaru bass mendalam, mikrofon jernih untuk telepon, daya tahan baterai hingga 24 jam dengan charging case.',
                'price' => 320000,
                'stock' => 15,
                'is_active' => true,
            ],
            [
                'category_id' => $casingCat?->id,
                'name' => 'Casing Hybrid Clear Case Shockproof Bumper Frame',
                'description' => 'Casing bening transparan dengan bumper sudut tahan benturan. Tidak mudah menguning, presisi tinggi untuk tombol dan kamera.',
                'price' => 65000,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'category_id' => $powerbankCat?->id,
                'name' => 'Powerbank Slim Fast Charge 20.000mAh Dual Output & LED Display',
                'description' => 'Pengisi daya portable kapasitas besar 20.000mAh desain tipis dengan indikator persentase baterai LED dan proteksi arus berlebih.',
                'price' => 290000,
                'stock' => 20,
                'is_active' => true,
            ],
            [
                'category_id' => $audioCat?->id,
                'name' => 'Headset Gaming Over-Ear Surround 7.1 RGB Lighting With Mic',
                'description' => 'Headphone gaming akustik tinggi dengan bantalan telinga empuk, pencahayaan LED RGB dynamic, dan mikrofon omnidirectional flexible.',
                'price' => 275000,
                'stock' => 12,
                'is_active' => true,
            ],
            [
                'category_id' => $casingCat?->id,
                'name' => 'Tempered Glass Anti-Spy Privacy Screen Protector Full Glue 9H',
                'description' => 'Pelindung layar kaca tempered anti-intip (privacy filter) dengan kekerasan 9H anti-gores dan permukaan oleophobic tahan sidik jari.',
                'price' => 45000,
                'stock' => 60,
                'is_active' => true,
            ],
            [
                'category_id' => $powerbankCat?->id,
                'name' => 'Holder HP Mobil Magnetik Strong Suction 360 Degree Rotation',
                'description' => 'Dudukan smartphone magnetik untuk dashboard dan kisi AC mobil. Daya cengkeram sangat kuat tahan guncangan jalan berlubang.',
                'price' => 55000,
                'stock' => 30,
                'is_active' => true,
            ],
        ];

        foreach ($products as $prod) {
            Product::updateOrCreate(
                ['slug' => Str::slug($prod['name'])],
                array_merge($prod, ['slug' => Str::slug($prod['name'])])
            );
        }
    }
}
