<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'icon' => '💻'],
            ['name' => 'Documents', 'icon' => '📄'],
            ['name' => 'Wallets', 'icon' => '👛'],
            ['name' => 'Bags', 'icon' => '🎒'],
            ['name' => 'Jewelry', 'icon' => '💍'],
            ['name' => 'Pets', 'icon' => '🐾'],
            ['name' => 'Others', 'icon' => '📦'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                [
                    'name' => $category['name'],
                    'description' => $category['name'].' items and related belongings.',
                    'icon' => $category['icon'],
                    'is_active' => true,
                ]
            );
        }
    }
}
