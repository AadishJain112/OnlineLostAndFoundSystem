<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    private static array $realisticCategories = [
        ['name' => 'Electronics', 'icon' => '💻'],
        ['name' => 'Mobile Phones', 'icon' => '📱'],
        ['name' => 'Wallets', 'icon' => '👛'],
        ['name' => 'Bags', 'icon' => '🎒'],
        ['name' => 'Documents', 'icon' => '📄'],
        ['name' => 'ID Cards', 'icon' => '🆔'],
        ['name' => 'Keys', 'icon' => '🔑'],
        ['name' => 'Jewelry', 'icon' => '💍'],
        ['name' => 'Laptops', 'icon' => '💻'],
        ['name' => 'Watches', 'icon' => '⌚'],
        ['name' => 'Clothing', 'icon' => '👔'],
        ['name' => 'Pets', 'icon' => '🐾'],
        ['name' => 'Books', 'icon' => '📚'],
        ['name' => 'Headphones', 'icon' => '🎧'],
        ['name' => 'Chargers', 'icon' => '🔌'],
        ['name' => 'Sports Items', 'icon' => '⚽'],
        ['name' => 'Accessories', 'icon' => '👓'],
        ['name' => 'Passports', 'icon' => '🛂'],
        ['name' => 'College IDs', 'icon' => '🎓'],
        ['name' => 'Vehicles', 'icon' => '🚗'],
    ];

    public function definition(): array
    {
        $category = fake()->randomElement(self::$realisticCategories);
        $name = $category['name'];
        $icon = $category['icon'];

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->generateCategoryDescription($name),
            'icon' => $icon,
            'is_active' => true,
        ];
    }

    private function generateCategoryDescription(string $categoryName): string
    {
        $descriptions = [
            'Electronics' => 'Electronic devices including computers, tablets, and other tech gadgets.',
            'Mobile Phones' => 'Smartphones and mobile communication devices.',
            'Wallets' => 'Wallets, purses, and personal carrying accessories.',
            'Bags' => 'Backpacks, tote bags, duffel bags, and luggage items.',
            'Documents' => 'Important papers, certificates, and official documents.',
            'ID Cards' => 'Government-issued identification cards and driver licenses.',
            'Keys' => 'House keys, car keys, and key chains.',
            'Jewelry' => 'Watches, necklaces, rings, bracelets, and other jewelry.',
            'Laptops' => 'Notebook computers and portable computing devices.',
            'Watches' => 'Wristwatches and timepieces of all kinds.',
            'Clothing' => 'Jackets, coats, scarves, and other clothing items.',
            'Pets' => 'Lost and found pets including dogs, cats, and other animals.',
            'Books' => 'Textbooks, novels, notebooks, and other reading materials.',
            'Headphones' => 'Earbuds, headphones, and audio devices.',
            'Chargers' => 'Phone chargers, power banks, and charging cables.',
            'Sports Items' => 'Sports equipment, gym bags, and athletic gear.',
            'Accessories' => 'Sunglasses, belts, hats, and other small accessories.',
            'Passports' => 'Travel passports and travel documents.',
            'College IDs' => 'Student identification cards and college credentials.',
            'Vehicles' => 'Cars, bicycles, motorcycles, and other vehicles.',
        ];

        return $descriptions[$categoryName] ?? $categoryName . ' items and related belongings.';
    }
}
