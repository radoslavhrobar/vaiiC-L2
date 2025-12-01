<?php

namespace App\Helpers;

enum Gender
{
    case Male;
    case Female;
    case Other;

    public static function from(string $gender): ?Gender
    {
        return match ($gender) {
            'male' => self::Male,
            'female' => self::Female,
            'other' => self::Other,
            default => null,
        };
    }
}