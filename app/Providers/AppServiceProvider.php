<?php

namespace App\Providers;

use App\Support\TranslationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use SocialiteProviders\Manager\SocialiteWasCalled;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::unguard();
        Model::preventLazyLoading(! app()->isProduction());

        app()->singleton(
            TranslationManager::class,
            fn () => new TranslationManager(),
        );

        Password::defaults(function () {
            return Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised();
        });

        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite(
                'microsoft',
                \SocialiteProviders\Microsoft\Provider::class,
            );
        });
    }
}
