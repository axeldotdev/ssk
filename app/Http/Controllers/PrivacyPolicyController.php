<?php

namespace App\Http\Controllers;

use App\Support\TranslationManager;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class PrivacyPolicyController extends Controller
{
    public function show(): Response
    {
        $policyFile = app(TranslationManager::class)
            ->currentLocale()
            ->markdownFile('policy.md');

        return Inertia::render('PrivacyPolicy', [
            'policy' => Str::markdown(file_get_contents($policyFile)),
        ]);
    }
}
