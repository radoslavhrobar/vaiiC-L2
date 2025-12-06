<?php

namespace App\Helpers;

enum Gender : string
{
    case Male = 'muž';
    case Female = 'žena';
    case Other = 'iné';

    public static function valueFrom(string $gender): ?string
    {
        return match ($gender) {
            'Male' => self::Male->value,
            'Female' => self::Female->value,
            'Other' => self::Other->value,
            default => null
        };
    }
}