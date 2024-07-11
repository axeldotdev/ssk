<?php

namespace App\Concerns;

use Illuminate\Support\Str;

trait HasUuid
{
    public static function bootHasUuid(): void
    {
        static::creating(function ($model): void {
            $model->uuid = (string) Str::uuid();
        });
    }
}
