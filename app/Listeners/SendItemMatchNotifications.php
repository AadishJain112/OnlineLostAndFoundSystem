<?php

namespace App\Listeners;

use App\Events\ItemMatchDetected;
use App\Notifications\ItemMatchFoundNotification;
class SendItemMatchNotifications
{
    public function handle(ItemMatchDetected $event): void
    {
        $match = $event->match->load(['lostItem.user', 'foundItem.user']);

        $match->lostItem->user->notify(new ItemMatchFoundNotification($match, 'lost'));
        $match->foundItem->user->notify(new ItemMatchFoundNotification($match, 'found'));

        $match->update(['notified_at' => now()]);
    }
}
