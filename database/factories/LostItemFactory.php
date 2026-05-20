<?php

namespace Database\Factories;

use App\Enums\ContactPreference;
use App\Enums\ItemStatus;
use App\Models\Category;
use App\Models\LostItem;
use App\Models\User;
use App\Services\ImageUploadService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LostItemFactory extends Factory
{
    protected $model = LostItem::class;

    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => rtrim($title, '.'),
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(6)),
            'description' => fake()->paragraph(3),
            'date_lost' => fake()->dateTimeBetween('-30 days', 'now'),
            'location' => fake()->city().', '.fake()->streetName(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'contact_preference' => fake()->randomElement(ContactPreference::cases())->value,
            'status' => ItemStatus::Lost,
            'verification_code' => ImageUploadService::verificationCode(),
        ];
    }
}
