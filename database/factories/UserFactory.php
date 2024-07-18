<?php

namespace Database\Factories;

use App\Enums\Country;
use App\Enums\Locale;
use App\Enums\Timezone;
use App\Models\Company;
use App\Models\ConnectedAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JoelButcher\Socialstream\Providers;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'current_company_id' => null,
            'firstname' => fake()->firstName(),
            'lastname' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('W544AW&t'),
            'remember_token' => Str::random(10),
            'country' => Country::France,
            'locale' => Locale::EN,
            'timezone' => Timezone::EuropeLondon,
            'verified_at' => now(),
            'onboarded_at' => now(),
            'anonymized_at' => null,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn () => [
            'verified_at' => null,
        ]);
    }

    public function notOnboarded(): static
    {
        return $this->state(fn () => [
            'onboarded_at' => null,
        ]);
    }

    public function anonymized(): static
    {
        return $this->state(fn () => [
            'anonymized_at' => now(),
        ]);
    }

    public function withCurrentCompany(?callable $callback = null): static
    {
        return $this->has(
            Company::factory()
                ->state(fn (array $attributes, User $user) => [
                    'user_id' => $user->id,
                ])
                ->when(is_callable($callback), $callback),
            'ownedCompanies'
        );
    }

    public function withConnectedAccount(string $provider, ?callable $callback = null): static
    {
        if (! Providers::enabled($provider)) {
            return $this->state([]);
        }

        return $this->has(
            ConnectedAccount::factory()
                ->state(fn (array $attributes, User $user) => [
                    'provider' => $provider,
                    'user_id' => $user->id,
                ])
                ->when(is_callable($callback), $callback)
        );
    }
}
