<?php

namespace App\Events;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Queue\SerializesModels;

class Verified
{
    use SerializesModels;

    public function __construct(
        public Authenticatable $user,
    ) {}
}
