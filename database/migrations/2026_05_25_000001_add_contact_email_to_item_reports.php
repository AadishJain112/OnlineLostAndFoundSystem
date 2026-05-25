<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->string('contact_email')->nullable()->after('contact_preference');
        });

        Schema::table('found_items', function (Blueprint $table) {
            $table->string('contact_email')->nullable()->after('contact_preference');
        });
    }

    public function down(): void
    {
        Schema::table('lost_items', function (Blueprint $table) {
            $table->dropColumn('contact_email');
        });

        Schema::table('found_items', function (Blueprint $table) {
            $table->dropColumn('contact_email');
        });
    }
};
