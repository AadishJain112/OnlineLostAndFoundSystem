<?php

namespace App\Enums;

enum ContactPreference: string
{
    case Email = 'email';
    case Phone = 'phone';
    case Platform = 'platform';

    public function label(): string
    {
        return match ($this) {
            self::Email => 'Email',
            self::Phone => 'Phone',
            self::Platform => 'Platform messaging only',
        };
    }
}
