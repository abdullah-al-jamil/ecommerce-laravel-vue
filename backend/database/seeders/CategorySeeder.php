<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'description' => 'Latest gadgets and electronics'],
            ['name' => 'Clothing', 'description' => 'Fashion and apparel'],
            ['name' => 'Home & Garden', 'description' => 'Home improvement and garden'],
            ['name' => 'Sports', 'description' => 'Sports equipment and gear'],
            ['name' => 'Books', 'description' => 'Books, magazines and more'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
