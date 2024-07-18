<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use OwenIt\Auditing\Contracts\Auditable;

/**
 * @mixin IdeHelperMembership
 */
class Membership extends Pivot implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    /** @var string */
    protected $table = 'company_user';
}
