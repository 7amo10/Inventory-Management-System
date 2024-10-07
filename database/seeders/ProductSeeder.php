<?php

namespace Database\Seeders;

use App\Models\Product;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class ProductSeeder extends Seeder
{
    public function run(): void
    {
       $product = Product::create([
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'name' => 'IPhone 14 Pro',
            'slug' => Str::slug('IPhone 14 Pro'),
            'code' => '1',
            'quantity' => 10,
            'buying_price' => 900,
            'selling_price' => 1400,
            'quantity_alert' => 5,
            'tax' => 24,
            'tax_type' => 1,
            'notes' => 'Latest iPhone model.',
            'product_image' => 'assets/img/products/ip14.png',
            'category_id' => 1,
            'unit_id' => 2,
            'supplier_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $product = Product::create([
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'name' => 'Logitech Speakers',
            'slug' => Str::slug('Logitech Speakers'),
            'code' => '2',
            'quantity' => 15,
            'buying_price' => 500,
            'selling_price' => 700,
            'quantity_alert' => 3,
            'tax' => 18,
            'tax_type' => 1,
            'notes' => 'High-quality sound system.',
            'product_image' => 'assets/img/products/speaker.png',
            'category_id' => 2,
            'unit_id' => 1,
            'supplier_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $product = Product::create([
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'name' => 'Samsung Galaxy S23',
            'slug' => Str::slug('Samsung Galaxy S23'),
            'code' => '3',
            'quantity' => 20,
            'buying_price' => 800,
            'selling_price' => 1200,
            'quantity_alert' => 6,
            'tax' => 20,
            'tax_type' => 1,
            'notes' => 'Latest Samsung flagship phone.',
            'product_image' => 'assets/img/products/laptop.png',
            'category_id' => 1,
            'unit_id' => 1,
            'supplier_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
