<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'category_id' => 1,
                'user_id' => 1,
                'name' => 'Wireless Bluetooth Headphones',
                'description' => 'High quality wireless headphones with noise cancellation',
                'price' => 79.99,
                'stock' => 50,
                'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
            ],
            [
                'category_id' => 1,
                'user_id' => 1,
                'name' => 'Smart Watch',
                'description' => 'Feature-rich smartwatch with health tracking',
                'price' => 199.99,
                'stock' => 30,
                'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400',
            ],
            [
                'category_id' => 2,
                'user_id' => 1,
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'Comfortable and stylish cotton t-shirt',
                'price' => 29.99,
                'stock' => 100,
                'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
            ],
            [
                'category_id' => 2,
                'user_id' => 1,
                'name' => 'Denim Jeans',
                'description' => 'Classic fit denim jeans',
                'price' => 59.99,
                'stock' => 75,
                'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=400',
            ],
            [
                'category_id' => 3,
                'user_id' => 1,
                'name' => 'Modern Table Lamp',
                'description' => 'Elegant table lamp for modern interiors',
                'price' => 45.99,
                'stock' => 40,
                'image' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400',
            ],
            [
                'category_id' => 3,
                'user_id' => 1,
                'name' => 'Indoor Plant Pot Set',
                'description' => 'Set of 3 ceramic plant pots',
                'price' => 34.99,
                'stock' => 60,
                'image' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=400',
            ],
            [
                'category_id' => 4,
                'user_id' => 1,
                'name' => 'Yoga Mat Premium',
                'description' => 'Non-slip yoga mat with carrying strap',
                'price' => 39.99,
                'stock' => 80,
                'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=400',
            ],
            [
                'category_id' => 4,
                'user_id' => 1,
                'name' => 'Fitness Tracker Band',
                'description' => 'Water-resistant fitness tracker',
                'price' => 49.99,
                'stock' => 55,
                'image' => 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=400',
            ],
            [
                'category_id' => 5,
                'user_id' => 1,
                'name' => 'Programming Best Practices',
                'description' => 'Learn programming from basics to advanced',
                'price' => 44.99,
                'stock' => 25,
                'image' => 'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=400',
            ],
            [
                'category_id' => 5,
                'user_id' => 1,
                'name' => 'Fiction Novel Collection',
                'description' => 'Bestselling fiction novels bundle',
                'price' => 54.99,
                'stock' => 35,
                'image' => 'https://images.unsplash.com/photo-1544947950-fa07a98d237f?w=400',
            ],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'category_id' => $product['category_id'],
                'user_id' => $product['user_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']) . '-' . time(),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'image' => $product['image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
