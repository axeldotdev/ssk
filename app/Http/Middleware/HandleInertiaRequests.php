<?php

namespace App\Http\Middleware;

use App\Enums\Country;
use App\Enums\Locale;
use App\Enums\Timezone;
use App\Models\Company;
use App\Models\Passkey;
use App\Support\TranslationManager;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /** @var string */
    protected $rootView = 'app';

    /** @return array<string, mixed> */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'appName' => config('app.name'),
            'appUrl' => config('app.url'),
            'appLocale' => config('app.locale'),
            'supportPhone' => config('services.support.phone'),
            'localeMessages' => fn () => app(TranslationManager::class)
                ->allLocales()
                ->messages(),
            'auth' => [...$this->auth($request)],
            'ziggy' => fn () => [
                ...(new Ziggy())->toArray(),
                'location' => $request->url(),
                'currentRoute' => $request->route()?->getName() ?? '',
            ],
            'flash' => [
                'message' => fn () => $request->session()->get('message'),
            ],
            ...$this->enums(),
        ];
    }

    public function auth(Request $request): array
    {
        return [
            'user' => $request->user(),
            'currentCompany' => $request->user()?->currentCompany
                ?->only(['uuid', 'name']),
            'companies' => $request->user()?->allCompanies()
                ->map->only(['uuid', 'name']),
            'can' => [...$this->policies($request)],
        ];
    }

    public function enums(): array
    {
        return [
            'countries' => fn () => Country::list(),
            'locales' => fn () => Locale::list(),
            'timezones' => fn () => Timezone::list(),
        ];
    }

    public function policies(Request $request): array
    {
        return [
            'viewAny' => [
                'companies' => fn () => $request->user()
                    ?->can('viewAny', Company::class),
            ],
            'create' => [
                'companies' => fn () => $request->user()
                    ?->can('create', Company::class),
                'passkeys' => fn () => $request->user()
                    ?->can('create', Passkey::class),
            ],
        ];
    }
}
