<?php

namespace App\Actions\Socialstream;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use JoelButcher\Socialstream\Contracts\CreatesConnectedAccounts;
use JoelButcher\Socialstream\Contracts\CreatesUserFromProvider;
use Laravel\Socialite\Contracts\User as ProviderUser;

class CreateUserFromProvider implements CreatesUserFromProvider
{
    public function __construct(
        public CreatesConnectedAccounts $createsConnectedAccounts,
    ) {}

    public function create(string $provider, ProviderUser $providerUser): User
    {
        return DB::transaction(function () use ($provider, $providerUser) {
            return tap(User::create([
                'firstname' => $providerUser->getName()
                    ?? $providerUser->getNickname(),
                'lastname' => '',
                'email' => $providerUser->getEmail(),
            ]), function (User $user) use ($provider, $providerUser) {
                $user->markUserAsVerified();

                $this->createsConnectedAccounts->create(
                    $user,
                    $provider,
                    $providerUser,
                );
            });
        });
    }
}
