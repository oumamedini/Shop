<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Ouma Admin',
            'email' => 'ouma1@admin.com',
            'password' => Hash::make('ouma123'),
            'is_admin' => true,
        ]);

        User::create([
            'name' => 'Ouma User',
            'email' => 'ouma2@user.com',
            'password' => Hash::make('ouma123'),
            'is_admin' => false,
        ]);

        $categories = [
            'Smartphones',
            'Furniture',
            'Sports',
            'Toys',
        ];

        $categoryIds = [];
        foreach ($categories as $categoryName) {
            $category = Category::create(['name' => $categoryName]);
            $categoryIds[$categoryName] = $category->id;
        }

        $products = [
            [
                'name' => 'Galaxy S22 Ultra',
                'description' => 'Flagship Samsung smartphone with advanced camera system, S Pen support, and powerful performance. Features a stunning 6.8" Dynamic AMOLED display and 5G connectivity.',
                'price' => 1199.99,
                'category' => 'Smartphones',
                'stock_quantity' => 50,
                'sku' => 'PHONE-S22U',
                'weight' => 0.228,
                'length' => 16.5,
                'width' => 7.7,
                'height' => 0.8,
                'status' => 1,
                'image' => null,
            ],
            [
                'name' => 'Modern Sofa Set',
                'description' => 'Elegant 3-piece sofa set with premium fabric upholstery and solid wood frame. Perfect for contemporary living rooms with its clean lines and comfortable design.',
                'price' => 799.00,
                'category' => 'Furniture',
                'stock_quantity' => 15,
                'sku' => 'FURN-SOFA3',
                'weight' => 85.5,
                'length' => 220.0,
                'width' => 95.0,
                'height' => 85.0,
                'status' => 1,
                'image' => null,
            ],
            [
                'name' => 'Mountain Bike',
                'description' => 'Professional-grade mountain bike with 21-speed gear system, dual suspension, and all-terrain tires. Built for durability and optimal performance on challenging trails.',
                'price' => 450.50,
                'category' => 'Sports',
                'stock_quantity' => 25,
                'sku' => 'SPRT-BIKE1',
                'weight' => 14.5,
                'length' => 180.0,
                'width' => 60.0,
                'height' => 110.0,
                'status' => 1,
                'image' => null,
            ],
            [
                'name' => 'LEGO Space Shuttle',
                'description' => 'Detailed LEGO space shuttle model with authentic features, opening payload bay, and deployable satellite. Educational building set perfect for young space enthusiasts.',
                'price' => 59.99,
                'category' => 'Toys',
                'stock_quantity' => 100,
                'sku' => 'TOY-LEGO1',
                'weight' => 0.85,
                'length' => 35.0,
                'width' => 25.0,
                'height' => 15.0,
                'status' => 1,
                'image' => null,
            ],
        ];
    
        foreach ($products as $productData) {
            Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'category_id' => $categoryIds[$productData['category']],
                'stock_quantity' => $productData['stock_quantity'],
                'sku' => $productData['sku'],
                'weight' => $productData['weight'],
                'length' => $productData['length'],
                'width' => $productData['width'],
                'height' => $productData['height'],
                'status' => $productData['status'],
                'image' => $productData['image'],
            ]);
        }
    }
}