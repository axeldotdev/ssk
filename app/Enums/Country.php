<?php

namespace App\Enums;

enum Country: string
{
    case France = 'france';

    public static function list(): array
    {
        $countries = [];

        foreach (self::cases() as $country) {
            $countries[$country->value] = $country->flag()
                . ' ' . $country->name();
        }

        return $countries;
    }

    public function name(): string
    {
        return match ($this) {
            self::France => 'France',
        };
    }

    public function flag(): string
    {
        return match ($this) {
            self::France => '🇫🇷',
        };
    }

    public function timezone(): Timezone
    {
        return match ($this) {
            self::France => Timezone::EuropeParis,
        };
    }
}
