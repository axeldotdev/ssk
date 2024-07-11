<?php

arch('debug')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

arch('actions')
    ->expect('App\Actions')
    ->not->toHaveSuffix('Action');

arch('commands')
    ->expect('App\Console\Commands')
    ->toExtend('Illuminate\Console\Command')
    ->not->toHaveSuffix('Command');

arch('concerns')
    ->expect('App\Concerns')
    ->toBeTraits()
    ->not->toHaveSuffix('Concern')
    ->not->toHaveSuffix('Trait');

arch('contracts')
    ->expect('App\Contracts')
    ->toBeInterfaces()
    ->not->toHaveSuffix('Contract')
    ->not->toHaveSuffix('Interface');

arch('enums')
    ->expect('App\Enums')
    ->toBeEnums()
    ->not->toHaveSuffix('Enum');

arch('controllers')
    ->expect('App\Http\Controllers')
    ->toExtend('App\Http\Controllers\Controller')
    ->toHaveSuffix('Controller');

arch('middleware')
    ->expect('App\Http\Middleware')
    ->not->toHaveSuffix('Middleware');

arch('requests')
    ->expect('App\Http\Requests')
    ->toExtend('Illuminate\Foundation\Http\FormRequest')
    ->toHaveSuffix('Request');

arch('resources')
    ->expect('App\Http\Resources')
    ->toExtend('Illuminate\Http\Resources\Json\JsonResource')
    ->toHaveSuffix('Resource');

arch('jobs')
    ->expect('App\Jobs')
    ->toImplement('Illuminate\Contracts\Queue\ShouldQueue')
    ->not->toHaveSuffix('Job');

arch('models')
    ->expect('App\Models')
    ->not->toHaveSuffix('Model')
    ->toImplement('OwenIt\Auditing\Contracts\Auditable');

arch('notifications')
    ->expect('App\Notifications')
    ->toExtend('Illuminate\Notifications\Notification')
    ->not->toHaveSuffix('Notification');

arch('policies')
    ->expect('App\Policies')
    ->toHaveSuffix('Policy');

arch('providers')
    ->expect('App\Providers')
    ->toHaveSuffix('Provider');

// test('saloon connectors')
//     ->expect('App\Http\Integrations\Integration\Connector')
//     ->toBeSaloonConnector()
//     ->toUseAcceptsJsonTrait()
//     ->toUseAlwaysThrowOnErrorsTrait();

// test('saloon requests')
//     ->expect('App\Http\Integrations\Integration\Requests\Request')
//     ->toBeSaloonRequest()
//     ->toHaveJsonBody()
//     ->toUseAcceptsJsonTrait()
//     ->toHaveCaching()
//     ->toHaveRateLimits();

// test('saloon responses')
//     ->expect('App\Http\Integrations\Integration\Responses\Response')
//     ->toBeSaloonResponse();
