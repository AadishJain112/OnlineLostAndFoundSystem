<?php

namespace Database\Factories;

use App\Enums\ContactPreference;
use App\Enums\ItemStatus;
use App\Models\Category;
use App\Models\FoundItem;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class FoundItemFactory extends Factory
{
    protected $model = FoundItem::class;

    private static array $itemTitles = [
        'Black leather wallet',
        'Silver wrist watch',
        'Blue backpack',
        'Wireless headphones',
        'Android smartphone',
        'Laptop computer',
        'Travel passport holder',
        'Designer sunglasses',
        'Leather jacket',
        'Canvas tote bag',
        'Waterproof sports watch',
        'Bluetooth speaker',
        'Classic fountain pen',
        'Portable power bank',
        'Digital camera',
    ];

    public function definition(): array
    {
        $title = fake()->randomElement(self::$itemTitles);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::lower(Str::random(6)),
            'description' => fake()->paragraph(3),
            'date_found' => fake()->dateTimeBetween('-20 days', 'now'),
            'location' => fake()->city() . ', ' . fake()->streetName(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'contact_preference' => fake()->randomElement(ContactPreference::cases())->value,
            'status' => ItemStatus::Found,
            'verification_code' => ImageUploadService::verificationCode(),
        ];
    }
}
