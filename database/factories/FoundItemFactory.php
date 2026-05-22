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

    private static array $foundDescriptions = [
        'Black leather wallet' => [
            'Found at checkout counter with ID cards and cash inside. Secured and waiting for owner.',
            'Black leather bifold wallet found at information desk. Kept in safe.',
            'Leather wallet discovered on transit bench. Items intact inside protective bag.',
        ],
        'Silver wrist watch' => [
            'Silver watch found in lost and found. Working condition. No visible damage.',
            'Stainless steel watch discovered in restroom. Kept for safekeeping.',
            'Digital sports watch found at entrance. Includes original band.',
        ],
        'Blue backpack' => [
            'Navy blue backpack found at storage area. Contents organized and secured.',
            'Blue hiking backpack with all items intact. Found at exit gate.',
            'Light blue travel bag found in seating area. Items preserved.',
        ],
        'Wireless headphones' => [
            'Black wireless headphones found with charging case and cable.',
            'Earbuds discovered in charging case. Battery working properly.',
            'Wireless headphones found in good working condition with accessories.',
        ],
        'Android smartphone' => [
            'Black smartphone found powered off. Secured for owner retrieval.',
            'Android device found intact. Password protected but all accessories included.',
            'Mobile phone discovered at security area. Locked and safe.',
        ],
        'Laptop computer' => [
            'MacBook found secured in case. Not opened or checked to preserve privacy. Kept at main desk.',
            'Dell laptop found in sealed bag. Password protected. Stored safely.',
            'HP laptop discovered intact with carrying case. Powered down.',
        ],
        'Travel passport holder' => [
            'Passport organizer found with documents intact. Kept in secure location.',
            'Leather travel wallet found with travel documents. All items accounted for.',
            'Passport holder discovered with personal documents. Secured safely.',
        ],
        'Designer sunglasses' => [
            'Ray-Ban sunglasses found with original case. Lenses intact.',
            'Designer sunglasses discovered in protective case. No scratches.',
            'Branded sunglasses found in pristine condition with case.',
        ],
        'Leather jacket' => [
            'Black leather jacket found in cloakroom area. Dry cleaned and stored properly.',
            'Genuine leather jacket discovered and kept for owner. Good condition.',
            'Brown leather coat found and secured. All items inside preserved.',
        ],
        'Canvas tote bag' => [
            'Canvas bag found with contents organized. All items inventoried.',
            'Beige canvas tote discovered with shopping items. Stored safely.',
            'Canvas bag found with personal items. Kept together.',
        ],
        'Waterproof sports watch' => [
            'Sports watch found and tested - working properly. Water-resistant band intact.',
            'Chronograph watch discovered in sports facility. Kept in protective case.',
            'Digital sports watch found with all functions working.',
        ],
        'Bluetooth speaker' => [
            'Portable speaker found with charging cable. All controls working.',
            'Waterproof speaker discovered in excellent condition. Battery functional.',
            'Compact speaker found with accessories. No damage detected.',
        ],
        'Classic fountain pen' => [
            'Fountain pen found intact with cap. Nib in good condition.',
            'Premium pen discovered with leather case. All parts accounted for.',
            'Luxury fountain pen found - working properly with refill cartridge.',
        ],
        'Portable power bank' => [
            'Power bank found with original cables. Holds charge properly.',
            'Portable charger discovered with all USB ports functional.',
            'Compact power bank found in good working condition. Cables included.',
        ],
        'Digital camera' => [
            'Camera found with all lenses and accessories. Memory card extracted for privacy.',
            'DSLR camera discovered with professional lens. All equipment intact.',
            'Digital camera found with protective case and original strap.',
        ],
    ];

    public function definition(): array
    {
        $title = fake()->randomElement(self::$itemTitles);
        $description = fake()->randomElement(self::$foundDescriptions[$title] ?? ['Found item. Owner can claim with proper identification.']);

        $realisticLocations = [
            'Downtown Shopping Center',
            'Central Railway Station',
            'City Bus Terminal',
            'Airport Terminal 2',
            'University Main Campus',
            'Shopping Mall, Near Cinema',
            'Airport Security Checkpoint',
            'Business District Office',
            'Public Library',
            'Beach Parking Area',
            'Hotel Lobby',
            'Restaurant Downtown',
            'Gym Facility',
            'Coffee Shop Near Park',
            'City Park Main Entrance',
            'Convention Center',
            'Hospital Lobby',
            'Office Building Lobby',
            'Train Station Platform 3',
            'Taxi Rank Downtown',
        ];

        // Get a random existing category or create one
        $category = Category::inRandomOrder()->first() ?? Category::factory()->create();

        return [
            'user_id' => User::factory(),
            'category_id' => $category->id,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::lower(Str::random(6)),
            'description' => $description,
            'date_found' => fake()->dateTimeBetween('-20 days', 'now'),
            'location' => fake()->randomElement($realisticLocations),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'contact_preference' => fake()->randomElement(ContactPreference::cases())->value,
            'status' => ItemStatus::Found,
            'verification_code' => ImageUploadService::verificationCode(),
        ];
    }
}

