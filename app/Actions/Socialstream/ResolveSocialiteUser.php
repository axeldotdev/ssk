<?php

namespace App\Actions\Socialstream;

use JoelButcher\Socialstream\Contracts\ResolvesSocialiteUsers;
use JoelButcher\Socialstream\Socialstream;
use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;

class ResolveSocialiteUser implements ResolvesSocialiteUsers
{
    public function resolve(string $provider): User
    {
        $user = Socialite::driver($provider)->user();

        if (Socialstream::generatesMissingEmails()) {
            // @phpstan-ignore-next-line
            $generatedEmail = "{$user->id}@{$provider}" . config('app.domain');
            // @phpstan-ignore-next-line
            $user->email = $user->getEmail() ?? $generatedEmail;
        }

        return $user;
    }
}
