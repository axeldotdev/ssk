<?php

namespace App\Enums;

use App\Concerns\HasList;

enum Locale: string
{
    use HasList;

    case EN = 'en';
    case FR = 'fr';

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

    public function label(): string
    {
        return $this->flag() . ' ' . $this->name();
    }
}
