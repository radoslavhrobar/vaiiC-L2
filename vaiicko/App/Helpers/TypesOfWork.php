<?php

namespace App\Helpers;

enum TypesOfWork : string
{
    case Film = '1888';
    case Seriál = '1932';
    case Kniha = '1455';

    public static function getYear(string $typeOfWork): string
    {
        return match($typeOfWork) {
            'Film' => self::Film->value,
            'Seriál' => self::Seriál->value,
            'Kniha' => self::Kniha->value,
            default => self::minYear(),
        };
    }

    public static function minYear(): string
    {
        return min(array_map(fn($case) => $case->value, self::cases()));
    }
}