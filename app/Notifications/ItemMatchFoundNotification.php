<?php

namespace App\Notifications;

use App\Models\ItemMatch;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ItemMatchFoundNotification extends Notification
{
    use Queueable;

    public function __construct(
        public ItemMatch $match,
        public string $perspective = 'lost',
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $lost = $this->match->lostItem;
        $found = $this->match->foundItem;

        return (new MailMessage)
            ->subject('Potential match found for your report')
            ->greeting('Hello '.$notifiable->name.'!')
            ->line('Our system detected a possible match between a lost and found item.')
            ->line('Lost: '.$lost->title)
            ->line('Found: '.$found->title)
            ->line('Match score: '.$this->match->match_score.'%')
            ->action('View match details', url('/dashboard'))
            ->line('Please review the report and contact the other party safely through the platform.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'item_match',
            'match_id' => $this->match->id,
            'lost_item_id' => $this->match->lost_item_id,
            'found_item_id' => $this->match->found_item_id,
            'match_score' => $this->match->match_score,
            'message' => 'A potential match was found for one of your reports.',
        ];
    }
}
