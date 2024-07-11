<?php

use Illuminate\Support\Str;

use function Pest\Stressless\stress;

test('the api has a fast response time', function () {
    $result = stress(Str::replace('https://', '', config('app.url') . '/api/config'));

    expect($result->requests()->duration()->med())
        ->toBeLessThan(100); // < 100.00ms
});

test('the web has a fast response time', function () {
    $result = stress(Str::replace('https://', '', config('app.url')));

    expect($result->requests()->duration()->med())
        ->toBeLessThan(100); // < 100.00ms
});
