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

    public function allUsers(): Collection
    {
        return $this->users()->push($this->user);
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(CompanyInvitation::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function users(): Collection
    {
        return $this->members()->with('user')->get()->map->user;
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
