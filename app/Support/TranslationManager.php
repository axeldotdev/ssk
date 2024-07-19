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
        $this->locale = request()->user()->locale ?? config('app.locale');

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
        $localName = preg_replace('#(\.md)$#i', '.' . $this->locale . '$1', $name);

        return Arr::first([
            resource_path('markdown/' . $localName),
            resource_path('markdown/' . $name),
        ], function ($path) {
            return file_exists($path);
        });
    }
}
