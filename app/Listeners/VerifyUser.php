<?php

namespace App\Listeners;

use App\Events\Verified;
use App\Notifications\VerifyPhone;
use Illuminate\Auth\Notifications\VerifyEmail;
use Laravel\Pennant\Feature;

class VerifyUser
{
    public function handle(Verified $event): void
    {
        if (Feature::inactive(\App\Features\VerifyUser::class)) {
            return;
        }

        /** @var \App\Models\User $user */
        $user = $event->user;

        if ($user->phone === null) {
            $user->notify(new VerifyEmail());
        }

        if ($user->email === null) {
            $verificationCode = random_int(100000, 999999);

            $user->update(['password' => $verificationCode]);

            $user->notify(new VerifyPhone($verificationCode));
        }
    }
}
