<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        Supplier::create([
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'name' => 'Ali',
            'email' => 'ali@example.com',
            'phone' => '0123456789',
            'address' => '123 Ali Street, Cairo',
            'shopname' => 'Ali Supplies',
            'type' => 'wholesaler',
            'photo' => 'assets/img/suppliers/ali.png',
            'account_holder' => 'Ali Mohamed',
            'account_number' => '1234567890',
            'bank_name' => 'Cairo Bank',
        ]);
        Supplier::create([
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'name' => 'Mohamed',
            'email' => 'mohamed@example.com',
            'phone' => '0987654321',
            'address' => '456 Mohamed Road, Giza',
            'shopname' => 'Mohamed Trade',
            'type' => 'retail',
            'photo' => 'assets/img/suppliers/mohamed.png',
            'account_holder' => 'Mohamed Ahmed',
            'account_number' => '0987654321',
            'bank_name' => 'National Bank',
        ]);

    }
}
