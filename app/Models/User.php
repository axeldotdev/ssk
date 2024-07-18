<?php

namespace App\Models;

use App\Concerns\HasUuid;
use App\Enums\Country;
use App\Enums\Locale;
use App\Enums\Timezone;
use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Events\UserUpdated;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    /** @return array<string, string> */
    protected $dispatchesEvents = [
        'created' => UserCreated::class,
        'updated' => UserUpdated::class,
        'deleted' => UserDeleted::class,
    ];

    public function isCurrentCompany(Company $company): bool
    {
        return $company->id === $this->currentCompany->id;
    }

    public function currentCompany(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'current_company_id');
    }

    public function switchCompany(?Company $company): bool
    {
        if (! $this->belongsToCompany($company)) {
            return false;
        }

        $this->update(['current_company_id' => $company->id]);

        $this->setRelation('currentCompany', $company);

        return true;
    }

    public function allCompanies(): Collection
    {
        return $this->ownedCompanies->merge($this->companies)
            ->sortBy('name');
    }

    public function ownedCompanies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, Membership::class)
            ->withPivot('role')
            ->as('membership');
    }

    public function ownsCompany($company)
    {
        if (is_null($company)) {
            return false;
        }

        return $this->id === $company->id;
    }

    public function belongsToCompany(?Company $company): bool
    {
        if (is_null($company)) {
            return false;
        }

        return $this->ownsCompany($company) || $this->companies->contains(
            fn ($c) => $c->id === $company->id
        );
    }

    public function markUserAsVerified(): bool
    {
        return $this->update([
            'verified_at' => $this->freshTimestamp(),
        ]);
    }

    public function markUserAsOnboarded(): bool
    {
        return $this->update([
            'onboarded_at' => $this->freshTimestamp(),
        ]);
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
        return in_array($this->email, [
            'jd@example.com',
        ]);
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
