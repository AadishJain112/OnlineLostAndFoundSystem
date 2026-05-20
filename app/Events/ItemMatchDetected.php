<?php

namespace App\Events;

use App\Models\ItemMatch;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ItemMatchDetected
{
    use Dispatchable, SerializesModels;

    public function __construct(public ItemMatch $match) {}
}
