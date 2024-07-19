<?php

namespace App\Http\Controllers;

use App\Support\TranslationManager;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class TermsOfServiceController extends Controller
{
    public function show(): Response
    {
        $termsFile = app(TranslationManager::class)
            ->currentLocale()
            ->markdownFile('terms.md');

        return Inertia::render('TermsOfService', [
            'terms' => Str::markdown(file_get_contents($termsFile)),
        ]);
    }
}
