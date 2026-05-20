<?php

namespace App\Enums;

enum ItemStatus: string
{
    case Lost = 'lost';
    case Found = 'found';
    case Matched = 'matched';
    case Returned = 'returned';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Lost => 'Lost',
            self::Found => 'Found',
            self::Matched => 'Matched',
            self::Returned => 'Returned',
            self::Closed => 'Closed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Lost => 'amber',
            self::Found => 'emerald',
            self::Matched => 'sky',
            self::Returned => 'indigo',
            self::Closed => 'slate',
        };
    }
}
