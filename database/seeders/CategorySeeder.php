<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = Category::create([
            'uuid' => Str::uuid(),
            'name' => "Fruits",
            'slug' => 'fruits',
            'user_id' => 1,
        ]);
        $category = Category::create([
            'uuid' => Str::uuid(),
            'name' => "Vegetables",
            'slug' => 'vegetables',
            'user_id' => 1,
        ]);

        $category = Category::create([
            'uuid' => Str::uuid(),
            'name' => "Meat",
            'slug' => 'meat',
            'user_id' => 1,
        ]);


    }
}
