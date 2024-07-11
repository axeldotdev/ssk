<?php

namespace App\Http\Controllers\Api;

use App\Enums\Country;
use App\Enums\Locale;
use App\Enums\Timezone;
use App\Http\Controllers\Controller;
use App\Support\TranslationManager;
use Illuminate\Http\JsonResponse;

class ConfigController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'appName' => config('app.name'),
            'appUrl' => config('app.url'),
            'appLocale' => config('app.locale'),
            'supportPhone' => config('services.support.phone'),
            'localeMessages' => fn () => app(TranslationManager::class)
                ->allLocales()
                ->messages(),
            'countries' => fn () => Country::list(),
            'locales' => fn () => Locale::list(),
            'timezones' => fn () => Timezone::list(),
        ]);
    }
}
