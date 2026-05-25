<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds performance indexes to frequently queried columns.
 *
 * Why these indexes matter:
 * - location: used in search filters with LIKE queries
 * - receiver_id + read_at: used to count unread messages per user
 * - notifiable columns + read_at: used to count unread notifications
 */
return new class extends Migration
{
    public function up(): void
    {
        // Index on location for search filter queries
        Schema::table('lost_items', function (Blueprint $table) {
            $table->index('location', 'lost_items_location_index');
        });

        Schema::table('found_items', function (Blueprint $table) {
            $table->index('location', 'found_items_location_index');
        });

        // Composite index for fast unread-message counts per user
        Schema::table('messages', function (Blueprint $table) {
            $table->index(['receiver_id', 'read_at'], 'messages_receiver_unread_index');
        });

        // Composite index for fast unread-notification counts per user
        Schema::table('notifications', function (Blueprint $table) {
            $table->index(
                ['notifiable_type', 'notifiable_id', 'read_at'],
                'notifications_notifiable_unread_index'
            );
        });
    }

    public function down(): void
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->dropIndex('lost_items_location_index');
        });

        Schema::table('found_items', function (Blueprint $table) {
            $table->dropIndex('found_items_location_index');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('messages_receiver_unread_index');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex('notifications_notifiable_unread_index');
        });
    }
};
