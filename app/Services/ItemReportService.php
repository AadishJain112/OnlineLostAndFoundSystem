<?php

namespace App\Services;

use App\Enums\ItemStatus;
use App\Models\FoundItem;
use App\Models\LostItem;
use App\Models\User;
use Illuminate\Support\Str;

class ItemReportService
{
    public function __construct(
        protected ImageUploadService $imageUploadService,
        protected MatchService $matchService,
    ) {
    }

    public function createLost(User $user, array $data, array $images = []): LostItem
    {
        $item = LostItem::create([
            ...$this->basePayload($data),
            'user_id' => $user->id,
            'date_lost' => $data['date_lost'],
            'status' => ItemStatus::Lost,
            'verification_code' => ImageUploadService::verificationCode(),
        ]);

        $this->imageUploadService->storeMany($item, $images, 'lost-items');

        return $item->load(['category', 'images', 'user']);
    }

    public function createFound(User $user, array $data, array $images = []): FoundItem
    {
        $item = FoundItem::create([
            ...$this->basePayload($data),
            'user_id' => $user->id,
            'date_found' => $data['date_found'],
            'status' => ItemStatus::Found,
            'verification_code' => ImageUploadService::verificationCode(),
        ]);

        $this->imageUploadService->storeMany($item, $images, 'found-items');
        $this->matchService->findMatchesForFound($item->fresh(['category', 'images', 'user']));

        return $item->load(['category', 'images', 'user']);
    }

    public function updateLost(LostItem $item, array $data, array $images = []): LostItem
    {
        $item->update([
            ...$this->basePayload($data, $item->slug),
            'date_lost' => $data['date_lost'],
        ]);

        if (!empty($images)) {
            $this->imageUploadService->storeMany($item, $images, 'lost-items');
        }

        return $item->fresh(['category', 'images', 'user']);
    }

    public function updateFound(FoundItem $item, array $data, array $images = []): FoundItem
    {
        $item->update([
            ...$this->basePayload($data, $item->slug),
            'date_found' => $data['date_found'],
        ]);

        if (!empty($images)) {
            $this->imageUploadService->storeMany($item, $images, 'found-items');
        }

        $this->matchService->findMatchesForFound($item->fresh(['category', 'images', 'user']));

        return $item->fresh(['category', 'images', 'user']);
    }

    private function basePayload(array $data, ?string $existingSlug = null): array
    {
        $slug = $existingSlug ?? Str::slug($data['title']) . '-' . Str::lower(Str::random(6));

        return [
            'category_id' => $data['category_id'],
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'],
            'location' => $data['location'],
            'latitude' => $data['latitude'] ?? null,
            'longitude' => $data['longitude'] ?? null,
            'contact_preference' => $data['contact_preference'] ?? 'platform',
            'contact_email' => $data['contact_preference'] === 'email' ? ($data['contact_email'] ?? null) : null,
        ];
    }
}
