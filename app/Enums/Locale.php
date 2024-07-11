<?php

namespace App\Enums;

enum Locale: string
{
    case EN = 'en';
    case FR = 'fr';

    public static function list(): array
    {
        $locales = [];

        foreach (self::cases() as $locale) {
            $locales[$locale->value] = $locale->flag() . ' ' . $locale->name();
        }

        return $locales;
    }

    public function name(): string
    {
        return match ($this) {
            self::EN => 'English',
            self::FR => 'Français',
        };
    }

    public function flag(): string
    {
        return match ($this) {
            self::EN => '🇬🇧',
            self::FR => '🇫🇷',
        };
    }
}
