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

    private static array $lostDescriptions = [
        'Black leather wallet' => [
            'RFID-blocking leather wallet with multiple card slots. Contains personal documents. Last seen at shopping center.',
            'Bifold black leather wallet, slim design. Contains driver\'s license and credit cards. Lost on public transport.',
            'Vintage black leather wallet, approximately 5 years old. Sentimental value. Missing since downtown visit.',
        ],
        'Silver wrist watch' => [
            'Silver-tone analog watch with leather strap. Quartz movement. Lost during morning commute.',
            'Stainless steel watch, approximately 10 years old but well-maintained. Has scratches on face. Missing for 2 days.',
            'Silver digital sports watch with chronograph. Lost at gym facility.',
        ],
        'Blue backpack' => [
            'Navy blue school backpack with multiple pockets and laptop compartment. Contains textbooks and laptop.',
            'Royal blue hiking backpack, waterproof material. Lost at bus terminal.',
            'Light blue travel backpack with TSA-approved locks. Contains important travel documents.',
        ],
        'Wireless headphones' => [
            'Black over-ear wireless headphones with noise cancellation. Brand new purchase. Lost at airport.',
            'White wireless earbuds in charging case. Lost at coffee shop last week.',
            'Silver wireless headphones with active noise cancellation. Lost during train journey.',
        ],
        'Android smartphone' => [
            'Samsung Galaxy phone, black color with cracked screen protector. Contains important photos and work documents.',
            'OnePlus smartphone in blue. Phone case included. Lost at shopping mall.',
            'Google Pixel phone, midnight black. Lost during office commute.',
        ],
        'Laptop computer' => [
            '13-inch MacBook Pro, silver, model 2022. Contains work projects and personal files. Lost at office building.',
            'Dell XPS laptop, blue exterior case. Contains university assignments. Lost at library.',
            '15-inch HP laptop, business model. Silver color. Lost during business trip.',
        ],
        'Travel passport holder' => [
            'Leather travel organizer with passport pocket. Contains international travel documents. Lost at airport.',
            'RFID-blocking passport holder with card slots. Lost during vacation.',
            'Passport wallet organizer, navy blue. Contains passport and travel insurance documents.',
        ],
        'Designer sunglasses' => [
            'Ray-Ban Wayfarer sunglasses with original case. Dark lenses, brown frame.',
            'Aviator sunglasses, gold frame with gradient lenses. Designer brand. Lost at beach.',
            'Polarized sunglasses with UV protection. Black frame. Lost at outdoor event.',
        ],
        'Leather jacket' => [
            'Black leather motorcycle jacket, size L. Well-maintained condition. Lost at restaurant.',
            'Brown genuine leather jacket with zipper pockets. Lost at shopping center.',
            'Black leather blazer, professional style. Lost at business conference.',
        ],
        'Canvas tote bag' => [
            'Large beige canvas tote bag with shopping items. Lost at supermarket.',
            'Canvas beach bag, colorful pattern. Contains personal items. Lost at park.',
            'Neutral canvas shopping bag with handles. Lost on public transport.',
        ],
        'Waterproof sports watch' => [
            'Sports chronograph watch with rubber band. Water-resistant. Lost at swimming facility.',
            'Digital sports watch, waterproof design. Lost during marathon event.',
            'Outdoor adventure watch with GPS. Lost at hiking trail.',
        ],
        'Bluetooth speaker' => [
            'Portable Bluetooth speaker, black color, with charging cable. Lost at picnic area.',
            'Waterproof Bluetooth speaker with excellent battery life. Lost at beach.',
            'Compact Bluetooth speaker, silver finish. Lost at office.',
        ],
        'Classic fountain pen' => [
            'Montblanc fountain pen with gold trim. Lost at business meeting.',
            'Luxury fountain pen, black barrel. Heirloom piece. Lost at home.',
            'Professional fountain pen with genuine leather case. Lost at conference.',
        ],
        'Portable power bank' => [
            '20000mAh portable charger with fast charging. Black color. Lost at airport.',
            'Compact power bank with multiple USB ports. Lost at hotel.',
            'Portable charger 10000mAh with LED display. Lost on flight.',
        ],
        'Digital camera' => [
            'Canon DSLR camera with professional lens. Contains vacation photos. Lost at tourist destination.',
            'Mirrorless camera with accessories. Lost at photography studio.',
            'Digital compact camera with zoom lens. Lost at travel destination.',
        ],
    ];

    public function definition(): array
    {
        $title = fake()->randomElement(self::$itemTitles);
        $description = fake()->randomElement(self::$lostDescriptions[$title] ?? ['Lost item. Any information appreciated.']);

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
            'date_lost' => fake()->dateTimeBetween('-30 days', 'now'),
            'location' => fake()->randomElement($realisticLocations),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'contact_preference' => fake()->randomElement(ContactPreference::cases())->value,
            'status' => ItemStatus::Lost,
            'verification_code' => ImageUploadService::verificationCode(),
        ];
    }
}

