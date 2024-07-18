<?php

namespace App\Models;

use App\Concerns\HasUuid;
use App\Events\CompanyCreated;
use App\Events\CompanyDeleted;
use App\Events\CompanyUpdated;
use App\Notifications\InviteCollaborator;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @mixin IdeHelperCompany
 */
class Company extends Model implements Auditable, HasMedia
{
    use HasFactory;
    use HasUuid;
    use InteractsWithMedia;
    use \OwenIt\Auditing\Auditable;

    /** @return array<int, string> */
    protected $appends = ['can'];

    /** @return array<string, string> */
    protected $dispatchesEvents = [
        'created' => CompanyCreated::class,
        'updated' => CompanyUpdated::class,
        'deleted' => CompanyDeleted::class,
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function allUsers()
    {
        return $this->users->merge([$this->owner]);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, Membership::class)
            ->withPivot('role')
            ->as('membership');
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(CompanyInvitation::class);
    }

    public function inviteCollaborators(array $emails): Collection
    {
        $invitations = new Collection();

        foreach ($emails as $email) {
            $invitation = $this->invitations()->create(['email' => $email]);

            Notification::route('mail', $email)->notify(
                new InviteCollaborator($invitation),
            );

            $invitations->push($invitation);
        }

        return $invitations;
    }

    public function hasUser(User $user): bool
    {
        return $this->users->contains($user)
            || $user->ownsCompany($this);
    }

    public function hasUserWithEmail(string $email): bool
    {
        return $this->allUsers()->contains(
            fn ($user) => $user->email === $email,
        );
    }

    public function hasUserWithPhone(string $phone): bool
    {
        return $this->allUsers()->contains(
            fn ($user) => $user->phone === $phone,
        );
    }

    public function removeUser(User $user): void
    {
        if ($user->current_company_id === $this->id) {
            $user->update(['current_company_id' => null]);
        }

        $this->users()->detach($user);
    }

    public function purge(): void
    {
        $this->owner()
            ->where('current_company_id', $this->id)
            ->update(['current_company_id' => null]);

        $this->users()
            ->where('current_company_id', $this->id)
            ->update(['current_company_id' => null]);

        $this->users()->detach();

        $this->delete();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('company-logo')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/svg+xml'])
            ->useFallbackUrl(Storage::url('default/company-logo.jpg'))
            ->useFallbackPath(Storage::path('default/company-logo.jpg'));
    }

    public function can(): Attribute
    {
        return Attribute::make(get: fn () => [
            'view' => request()->user()?->can('view', $this),
            'update' => request()->user()?->can('update', $this),
            'delete' => request()->user()?->can('delete', $this),
        ]);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
