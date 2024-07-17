<?php

namespace App\Enums;

use App\Concerns\HasList;

enum Country: string
{
    use HasList;

    case France = 'france';

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

    public function label(): string
    {
        return $this->flag() . ' ' . $this->name();
    }
}
