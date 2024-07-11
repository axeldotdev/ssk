<?php

namespace App\Models;

use App\Concerns\HasUuid;
use App\Enums\Country;
use App\Enums\Locale;
use App\Enums\Timezone;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use JoelButcher\Socialstream\HasConnectedAccounts;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable implements Auditable, FilamentUser, HasName
{
    use HasApiTokens;
    use HasConnectedAccounts;
    use HasFactory;
    use HasUuid;
    use Notifiable;
    use \OwenIt\Auditing\Auditable;

    /** @var array<int, string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function allCompanies(): Collection
    {
        return $this->companies()->merge($this->ownedCompanies);
    }

    public function companies(): Collection
    {
        return $this->members()->with('company')->get()->map->company;
    }

    public function currentCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'current_company_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function ownedCompanies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function markUserAsVerified(): bool
    {
        return $this->forceFill([
            'verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function markUserAsOnboarded(): bool
    {
        return $this->forceFill([
            'onboarded_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function isOnboarded(): bool
    {
        return ! is_null($this->onboarded_at);
    }

    public function isVerified(): bool
    {
        return ! is_null($this->verified_at);
    }

    public function phone(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value,
            set: fn ($value) => str($value)->replace(' ', ''),
        );
    }

    public function routeNotificationForVonage(): string
    {
        return $this->phone;
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return str($this->email)->endsWith('@orvea.io');
    }

    public function getFilamentName(): string
    {
        return $this->fullname;
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'anonymized_at' => 'datetime',
            'country' => Country::class,
            'verified_at' => 'datetime',
            'locale' => Locale::class,
            'onboarded_at' => 'datetime',
            'password' => 'hashed',
            'timezone' => Timezone::class,
        ];
    }
}
