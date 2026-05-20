<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lost_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->date('date_lost');
            $table->string('location');
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->string('contact_preference')->default('platform');
            $table->string('status')->default('lost');
            $table->string('verification_code', 32)->unique();
            $table->timestamp('recovered_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'category_id']);
            $table->index('date_lost');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lost_items');
    }
};
