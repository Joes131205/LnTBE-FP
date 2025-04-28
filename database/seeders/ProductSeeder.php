<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Electronics
            [
                'category_id' => 1,
                'name' => 'Smartphone XYZ',
                'price' => 7900000,
                'quantity' => 50,
                'image' => 'smartphone.jpg'
            ],
            [
                'category_id' => 1,
                'name' => 'Laptop Pro',
                'price' => 12990000,
                'quantity' => 30,
                'image' => 'laptop.jpg'
            ],
            [
                'category_id' => 1,
                'name' => 'Wireless Headphones',
                'price' => 1490000,
                'quantity' => 100,
                'image' => 'headphones.jpg'
            ],
            
            [
                'category_id' => 2,
                'name' => 'T-Shirt',
                'price' => 199000,
                'quantity' => 200,
                'image' => 'tshirt.jpg'
            ],
            [
                'category_id' => 2,
                'name' => 'Jeans',
                'price' => 490000,
                'quantity' => 150,
                'image' => 'jeans.jpg'
            ],
                        [
                'category_id' => 3,
                'name' => 'Coffee Maker',
                'price' => 890000,
                'quantity' => 40,
                'image' => 'coffeemaker.jpg'
            ],
            [
                'category_id' => 3,
                'name' => 'Blender',
                'price' => 590000,
                'quantity' => 60,
                'image' => 'blender.jpg'
            ],

            [
                'category_id' => 4,
                'name' => 'Fiction Bestseller',
                'price' => 140000,
                'quantity' => 100,
                'image' => 'book.jpg'
            ],

            [
                'category_id' => 5,
                'name' => 'Basketball',
                'price' => 299000,
                'quantity' => 80,
                'image' => 'basketball.jpg'
            ],

            [
                'category_id' => 6,
                'name' => 'Board Game',
                'price' => 340000,
                'quantity' => 50,
                'image' => 'boardgame.jpg'
            ],

            [
                'category_id' => 7,
                'name' => 'Facial Moisturizer',
                'price' => 240000,
                'quantity' => 120,
                'image' => 'moisturizer.jpg'
            ],

            [
                'category_id' => 8,
                'name' => 'Car Phone Mount',
                'price' => 190000,
                'quantity' => 90,
                'image' => 'carmount.jpg'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}