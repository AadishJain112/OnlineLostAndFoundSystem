<?php

namespace App\Models;

use App\Enums\ContactPreference;
use App\Enums\ItemStatus;
use App\Traits\HasComments;
use App\Traits\HasItemImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class LostItem extends Model
{
    use HasComments, HasFactory, HasItemImages;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'description',
        'date_lost',
        'location',
        'latitude',
        'longitude',
        'contact_preference',
        'contact_email',
        'status',
        'verification_code',
        'recovered_at',
    ];

    protected function casts(): array
    {
        return [
            'date_lost' => 'date',
            'contact_preference' => ContactPreference::class,
            'status' => ItemStatus::class,
            'recovered_at' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function matches(): HasMany
    {
        return $this->hasMany(ItemMatch::class);
    }

    public function bookmarks(): MorphMany
    {
        return $this->morphMany(Bookmark::class, 'bookmarkable');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isOpen(): bool
    {
        return in_array($this->status, [ItemStatus::Lost, ItemStatus::Matched], true);
    }
}
