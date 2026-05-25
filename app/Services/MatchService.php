<?php

namespace App\Services;

use App\Enums\ItemStatus;
use App\Events\ItemMatchDetected;
use App\Models\FoundItem;
use App\Models\ItemMatch;
use App\Models\LostItem;
use Illuminate\Support\Str;

class MatchService
{
    public function findMatchesForFound(FoundItem $foundItem): void
    {
        if (! $foundItem->isOpen()) {
            return;
        }

        $candidates = LostItem::query()
            ->with('user')
            ->where('category_id', $foundItem->category_id)
            ->whereIn('status', [ItemStatus::Lost, ItemStatus::Matched])
            ->get();

        foreach ($candidates as $lostItem) {
            $score = $this->calculateScore($lostItem, $foundItem);

            if ($score < 60) {
                continue;
            }

            // firstOrCreate is not atomic under concurrent requests.
            // Use updateOrCreate so the unique constraint on
            // (lost_item_id, found_item_id) acts as the real guard,
            // and only update match_score if the row is new.
            $match = ItemMatch::firstOrCreate(
                [
                    'lost_item_id' => $lostItem->id,
                    'found_item_id' => $foundItem->id,
                ],
                ['match_score' => $score]
            );

            // Only fire the event when:
            //  - the match row was just created (wasRecentlyCreated), OR
            //  - it existed but was never notified (notified_at is null).
            // This prevents re-firing on every found-item update.
            if ($match->wasRecentlyCreated || $match->notified_at === null) {
                $lostItem->update(['status' => ItemStatus::Matched]);
                $foundItem->update(['status' => ItemStatus::Matched]);
                event(new ItemMatchDetected($match));
            }
        }
    }

    public function calculateScore(LostItem $lost, FoundItem $found): int
    {
        $score = 40;

        if ($lost->category_id === $found->category_id) {
            $score += 20;
        }

        similar_text(
            Str::lower($lost->title.' '.$lost->description),
            Str::lower($found->title.' '.$found->description),
            $textPercent
        );
        $score += (int) round($textPercent * 0.3);

        similar_text(
            Str::lower($lost->location),
            Str::lower($found->location),
            $locationPercent
        );
        $score += (int) round($locationPercent * 0.1);

        return min(100, $score);
    }
}
