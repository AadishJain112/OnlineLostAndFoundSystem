<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FoundItem;
use App\Models\LostItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(CategorySeeder::class);

        $admin = User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'phone' => '+10000000001',
        ]);

        $demo = User::factory()->create([
            'name' => 'Demo User',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'phone' => '+10000000002',
        ]);

        User::factory(8)->create();

        $categories = Category::all();

        LostItem::factory(15)->create([
            'user_id' => $demo->id,
        ])->each(function (LostItem $item) use ($categories) {
            $item->update(['category_id' => $categories->random()->id]);
        });

        FoundItem::factory(12)->create([
            'user_id' => $demo->id,
        ])->each(function (FoundItem $item) use ($categories) {
            $item->update(['category_id' => $categories->random()->id]);
        });

        LostItem::factory(10)->create()->each(fn (LostItem $item) => $item->update([
            'category_id' => $categories->random()->id,
        ]));

        FoundItem::factory(10)->create()->each(fn (FoundItem $item) => $item->update([
            'category_id' => $categories->random()->id,
        ]));
    }
}
