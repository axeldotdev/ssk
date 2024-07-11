<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperCompanyInvitation
 */
class CompanyInvitation extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
