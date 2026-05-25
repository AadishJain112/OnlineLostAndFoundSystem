<?php

namespace App\Notifications;

use App\Enums\ContactPreference;
use App\Models\ItemMatch;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/**
 * Notifies a user (or an anonymous email address) that a potential
 * match was found between a lost item and a found item.
 *
 * Channels used per notifiable type:
 *
 *  - AnonymousNotifiable  → mail only  (external contact_email address)
 *  - User whose item uses ContactPreference::Email
 *                         → database only  (the anonymous route already
 *                           handles the actual email to contact_email,
 *                           so we only store the in-app notification)
 *  - All other Users      → mail + database  (account email + in-app)
 *
 * Implements ShouldQueue so every channel dispatch goes through the
 * queue, keeping HTTP responses fast and retries safe.
 */
class ItemMatchFoundNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * How many times the queued job may be attempted before failing.
     * Keeps a transient mail/DB hiccup from spamming the user.
     */
    public int $tries = 3;

    /**
     * Seconds to wait before retrying after a failure.
     */
    public int $backoff = 60;

    public function __construct(
        public readonly ItemMatch $match,
        public readonly string $perspective = 'lost',
    ) {}

    /**
     * Determine which channels to use based on who is being notified.
     */
    public function via(object $notifiable): array
    {
        // Anonymous notifiable = external contact_email address.
        // Only send mail; there is no database record to write to.
        if ($notifiable instanceof AnonymousNotifiable) {
            return ['mail'];
        }

        if ($notifiable instanceof User) {
            $item = $this->perspective === 'lost'
                ? $this->match->lostItem
                : $this->match->foundItem;

            // User chose email contact preference AND supplied a contact_email.
            // The listener sends a separate anonymous mail to that address,
            // so here we only write the in-app (database) notification to
            // avoid sending a second email to the user's account address.
            if (
                $item->contact_preference === ContactPreference::Email
                && ! empty($item->contact_email)
            ) {
                return ['database'];
            }
        }

        // Default: send both an account email and an in-app notification.
        return ['mail', 'database'];
    }

    /**
     * Build the mail message sent to the user's account email address
     * or to an anonymous contact_email address.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $lost  = $this->match->lostItem;
        $found = $this->match->foundItem;
        $name  = data_get($notifiable, 'name', data_get($notifiable, 'routes.mail', 'there'));

        return (new MailMessage)
            ->subject('Potential match found for your report')
            ->greeting('Hello ' . $name . '!')
            ->line('Our system detected a possible match between a lost and found item.')
            ->line('Lost: '   . $lost->title)
            ->line('Found: '  . $found->title)
            ->line('Match score: ' . $this->match->match_score . '%')
            ->action('View match details', url('/dashboard'))
            ->line('Please review the report and contact the other party safely through the platform.');
    }

    /**
     * Data stored in the notifications table for in-app display.
     *
     * match_id is cast to int explicitly so it is stored as a JSON number
     * (e.g. {"match_id":5}) not a JSON string ({"match_id":"5"}).
     * The duplicate-check query in the listener relies on this being numeric.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type'          => 'item_match',
            'match_id'      => (int) $this->match->id,
            'lost_item_id'  => (int) $this->match->lost_item_id,
            'found_item_id' => (int) $this->match->found_item_id,
            'match_score'   => (int) $this->match->match_score,
            'message'       => 'A potential match was found for one of your reports.',
        ];
    }
}
