<?php

namespace App\Providers\Filament;

use App\Http\Middleware\EnsureUserIsLocalized;
use App\Http\Middleware\EnsureUserIsOnboarded;
use App\Http\Middleware\EnsureUserIsVerified;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel = $this->configurePanel($panel);
        $panel = $this->configureResources($panel);

        return $this->configureMiddlewares($panel);
    }

    public function configurePanel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('tools/admin')
            ->colors([
                'primary' => Color::Neutral,
            ]);
    }

    public function configureResources(Panel $panel): Panel
    {
        return $panel
            ->discoverResources(
                in: app_path('Filament/Resources'),
                for: 'App\\Filament\\Resources',
            )
            ->discoverPages(
                in: app_path('Filament/Pages'),
                for: 'App\\Filament\\Pages',
            )
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(
                in: app_path('Filament/Widgets'),
                for: 'App\\Filament\\Widgets',
            )
            ->widgets([]);
    }

    public function configureMiddlewares(Panel $panel): Panel
    {
        return $panel
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                EnsureUserIsVerified::class,
                EnsureUserIsOnboarded::class,
                EnsureUserIsLocalized::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
