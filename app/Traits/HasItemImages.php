<?php

namespace App\Traits;

use App\Models\ItemImage;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasItemImages
{
    public function images(): MorphMany
    {
        return $this->morphMany(ItemImage::class, 'imageable')->orderBy('sort_order');
    }

    public function primaryImage(): ?ItemImage
    {
        return $this->images->first();
    }
}
