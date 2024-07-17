<?php

namespace App\Concerns;

trait HasList
{
    public static function list(): array
    {
        $items = [];

        foreach (self::cases() as $item) {
            $items[$item->value] = $item->label();
        }

        return $items;
    }

    public function label(): string
    {
        return $this->name();
    }
}
