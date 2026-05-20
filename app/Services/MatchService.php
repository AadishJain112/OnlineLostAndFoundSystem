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

            $match = ItemMatch::firstOrCreate(
                [
                    'lost_item_id' => $lostItem->id,
                    'found_item_id' => $foundItem->id,
                ],
                ['match_score' => $score]
            );

            if ($match->wasRecentlyCreated || ! $match->notified_at) {
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
