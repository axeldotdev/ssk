<?php

namespace App\Support;

use Illuminate\Support\Arr;

class TranslationManager
{
    protected ?string $locale;

    public function allLocales(): self
    {
        $this->locale = null;

        return $this;
    }

    public function currentLocale(): self
    {
        $this->locale = request()->user()->locale->value ?? config('app.locale');

        return $this;
    }

    public function messages(): array
    {
        if (is_null($this->locale)) {
            return collect(glob(base_path('lang/*')))
                ->mapWithKeys(fn ($path) => [
                    basename($path, '.json') => json_decode(
                        $this->changeParamsForI18N(file_get_contents($path)),
                        true,
                    ),
                ])->toArray();
        }

        return json_decode(
            $this->changeParamsForI18N(
                file_get_contents(base_path("lang/{$this->locale}.json")),
            ),
            true,
        );
    }

    public function changeParamsForI18N(string $content): string
    {
        return preg_replace_callback(
            '/\:(\w+)/',
            fn ($matches) => '{' . $matches[1] . '}',
            $content,
        );
    }

    public function markdownFile(string $name): string
    {
        return $this->file($name, 'markdown/');
    }

    public function documentationFile(
        string $firstLevel,
        ?string $secondLevel = null,
    ): string {
        $folderPath = 'markdown/documentation/';
        $name = ($secondLevel ?? $firstLevel) . '.md';

        if ($secondLevel) {
            $folderPath .= "{$firstLevel}/";
        }

        return $this->file($name, $folderPath);
    }

    public function file(
        string $name,
        string $folderPath = 'markdown/documentation/',
    ): string {
        $localName = preg_replace(
            '#(\.md)$#i',
            '.' . $this->locale . '$1',
            $name,
        );

        return Arr::first([
            resource_path($folderPath . $localName),
            resource_path($folderPath . $name),
        ], function ($path) {
            return file_exists($path);
        });
    }
}
