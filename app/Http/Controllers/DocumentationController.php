<?php

namespace App\Http\Controllers;

use App\Support\TranslationManager;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class DocumentationController extends Controller
{
    public function show(string $firstLevel, ?string $secondLevel = null): Response
    {
        $documentationFile = app(TranslationManager::class)
            ->currentLocale()
            ->documentationFile($firstLevel, $secondLevel);

        return Inertia::render('Documentation', [
            'title' => __(Str::headline($firstLevel))
                . ($secondLevel ? ' - ' . __(Str::headline($secondLevel)) : ''),
            'content' => Str::markdown(file_get_contents($documentationFile)),
        ]);
    }
}
