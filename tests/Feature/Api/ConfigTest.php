<?php

it('can get the config', function () {
    $response = $this->getJson('api/config');

    $response
        ->assertOk()
        ->assertJsonStructure([
            'appName',
            'appUrl',
            'appLocale',
            'supportPhone',
            'localeMessages',
            'countries',
            'locales',
            'timezones',
        ]);
});
