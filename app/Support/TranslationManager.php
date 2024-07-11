<?php

namespace App\Support;

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
}
