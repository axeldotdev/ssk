<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperMember
 */
class Member extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public static function createFor(Company $company, User $user): self
    {
        return self::create([
            'company_id' => $company->id,
            'user_id' => $user->id,
        ]);
    }

    public static function users(Company $company): Builder
    {
        return User::query()
            ->join('members', 'users.id', '=', 'members.user_id')
            ->where('members.company_id', $company->id);
    }

    public static function companies(User $user): Builder
    {
        return Company::query()
            ->join('members', 'companies.id', '=', 'members.company_id')
            ->where('members.user_id', $user->id);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFor($query, Company $company, User $user)
    {
        return $query
            ->where('company_id', $company->id)
            ->where('user_id', $user->id);
    }
}
