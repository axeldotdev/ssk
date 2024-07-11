<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    public function boot(): void
    {
        parent::boot();

        Horizon::routeMailNotificationsTo('tech@orvea.io');
    }

    protected function gate(): void
    {
        Gate::define('viewHorizon', function ($user) {
            return str($user->email)->endsWith('@orvea.io');
        });
    }
}
