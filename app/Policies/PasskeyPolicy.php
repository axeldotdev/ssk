<?php

namespace App\Policies;

use App\Features\SignViaPasskey;
use App\Models\Passkey;
use App\Models\User;
use Laravel\Pennant\Feature;

class PasskeyPolicy
{
    public function create(): bool
    {
        return Feature::active(SignViaPasskey::class);
    }

    public function delete(User $user, Passkey $passkey): bool
    {
        return $user->id === $passkey->user_id;
    }
}
