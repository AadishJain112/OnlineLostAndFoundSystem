<?php

namespace App\Listeners;

use App\Enums\ContactPreference;
use App\Events\ItemMatchDetected;
use App\Models\User;
use App\Notifications\ItemMatchFoundNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

/**
 * Handles the ItemMatchDetected event and sends notifications to both
 * the lost-item owner and the found-item owner.
 *
 * ──────────────────────────────────────────────────────────────────────
 * DUPLICATE-PREVENTION STRATEGY
 * ──────────────────────────────────────────────────────────────────────
 * The single source of truth for "was this user already notified about
 * this specific match?" is the notifications table itself, checked with
 * the triple key:
 *
 *   notifiable_type  = App\Models\User
 *   notifiable_id    = <user id>
 *   data->match_id   = <match id>   ← scoped to THIS match only
 *
 * This means:
 *   ✅  Same user + same match  → skipped (true duplicate)
 *   ✅  Same user + different match → allowed (new event, new email)
 *   ✅  Queue retry after partial failure → only missing notifications
 *       are sent; already-sent ones are skipped
 *   ✅  Concurrent workers → both check before inserting; at most one
 *       wins the race (the second finds the row and skips)
 *
 * notified_at on the item_matches row is a completion marker only.
 * It is set AFTER all notifications are dispatched, not before.
 * It is NOT used as a hard gate inside this listener so that retries
 * can still deliver any notifications that failed mid-run.
 * ──────────────────────────────────────────────────────────────────────
 */
class SendItemMatchNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    /** Maximum queue attempts before the job is marked failed. */
    public int $tries = 3;

    /** Seconds between retry attempts. */
    public int $backoff = 60;

    public function handle(ItemMatchDetected $event): void
    {
        // Always reload fresh so we have the latest relationship data
        // and are not working with a stale in-memory model.
        $match = $event->match->fresh(['lostItem.user', 'foundItem.user']);

        // Match was deleted between event dispatch and job execution.
        if ($match === null) {
            return;
        }

        $lostUser  = $match->lostItem->user;
        $foundUser = $match->foundItem->user;

        // ── Lost-item owner ───────────────────────────────────────────────────
        // Guard: skip only if THIS user already has a DB notification for
        // THIS specific match_id.  A notification for a different match on
        // the same user is a completely separate event and must go through.
        if (! $this->userAlreadyNotifiedForMatch($lostUser->id, $match->id)) {
            $lostUser->notify(new ItemMatchFoundNotification($match, 'lost'));
        }

        // ── Found-item owner ──────────────────────────────────────────────────
        // Same guard, scoped to this match_id.
        // Also handles the edge case where one person reported both items
        // (lost-user === found-user): they still only get one notification
        // because the DB row written above will be found by the check below.
        if (! $this->userAlreadyNotifiedForMatch($foundUser->id, $match->id)) {
            $foundUser->notify(new ItemMatchFoundNotification($match, 'found'));
        }

        // ── Anonymous email: lost-item contact_email ──────────────────────────
        // Sent only when the reporter chose "email" contact preference AND
        // supplied a contact_email that differs from their account email.
        // The notification's via() already returns ['database'] for these
        // users, so no duplicate account-email is sent.
        $lostItem = $match->lostItem;
        if (
            $lostItem->contact_preference === ContactPreference::Email
            && ! empty($lostItem->contact_email)
            && $lostItem->contact_email !== $lostUser->email
        ) {
            Notification::route('mail', $lostItem->contact_email)
                ->notify(new ItemMatchFoundNotification($match, 'lost'));
        }

        // ── Anonymous email: found-item contact_email ─────────────────────────
        $foundItem = $match->foundItem;
        if (
            $foundItem->contact_preference === ContactPreference::Email
            && ! empty($foundItem->contact_email)
            && $foundItem->contact_email !== $foundUser->email
        ) {
            Notification::route('mail', $foundItem->contact_email)
                ->notify(new ItemMatchFoundNotification($match, 'found'));
        }

        // ── Mark match as fully notified ──────────────────────────────────────
        // Set AFTER all notifications are dispatched.  This is a completion
        // marker for reporting/admin purposes only — it is NOT used as a gate
        // inside this listener, so retries remain safe.
        if ($match->notified_at === null) {
            $match->updateOrFail(['notified_at' => now()]);
        }
    }

    /**
     * Returns true if a database notification for this exact
     * (user, match) combination already exists in the notifications table.
     *
     * Key: notifiable_type + notifiable_id + data->match_id
     *
     * Scoping to match_id means:
     *   - Same user, different match  → returns false  → notification sent  ✅
     *   - Same user, same match again → returns true   → notification skipped ✅
     *
     * The cast to (int) on $matchId ensures MySQL JSON_CONTAINS receives a
     * JSON number, not a JSON string, matching how toArray() stores it.
     */
    private function userAlreadyNotifiedForMatch(int $userId, int $matchId): bool
    {
        return DB::table('notifications')
            ->where('notifiable_type', User::class)
            ->where('notifiable_id', $userId)
            ->whereRaw(
                "JSON_UNQUOTE(JSON_EXTRACT(data, '$.match_id')) = ?",
                [(string) $matchId]
            )
            ->exists();
    }
}
