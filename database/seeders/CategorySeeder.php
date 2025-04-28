<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics'],
            ['name' => 'Clothing'],
            ['name' => 'Home & Kitchen'],
            ['name' => 'Books'],
            ['name' => 'Sports & Outdoors'],
            ['name' => 'Toys & Games'],
            ['name' => 'Health & Beauty'],
            ['name' => 'Automotive'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}