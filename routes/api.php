<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ConfigController;
use App\Http\Controllers\Api\CurrentCompanyController;
use App\Http\Controllers\Api\CurrentUserController;
use App\Http\Controllers\Api\MembershipController;
use App\Http\Controllers\Api\SwitchCompanyController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\UserController;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('config', [ConfigController::class, 'index']);

Route::post('tokens/create', [TokenController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('user', [CurrentUserController::class, 'show']);
    Route::put('user', [CurrentUserController::class, 'update']);

    Route::put(
        'switch-company/{company}',
        [SwitchCompanyController::class, 'update'],
    );

    Route::get('company', [CurrentCompanyController::class, 'show']);
    Route::put('company', [CurrentCompanyController::class, 'update']);

    Route::get('users', [UserController::class, 'index'])
        ->can('viewAny', User::class);
    Route::post('users', [UserController::class, 'store'])
        ->can('create', User::class);
    Route::get('users/{user}', [UserController::class, 'show'])
        ->can('view', 'user');
    Route::put('users/{user}', [UserController::class, 'update'])
        ->can('update', 'user');
    Route::delete('users/{user}', [UserController::class, 'destroy'])
        ->can('delete', 'user');

    Route::get('companies', [CompanyController::class, 'index'])
        ->can('viewAny', User::class);
    Route::post('companies', [CompanyController::class, 'store'])
        ->can('create', User::class);
    Route::get('companies/{company}', [CompanyController::class, 'show'])
        ->can('view', 'company');
    Route::put('companies/{company}', [CompanyController::class, 'update'])
        ->can('update', 'company');
    Route::delete('companies/{company}', [CompanyController::class, 'destroy'])
        ->can('delete', 'company');

    Route::get('companies/{company}/users', [MembershipController::class, 'index'])
        ->can('viewAny', Membership::class);
    Route::post('companies/{company}/users', [MembershipController::class, 'store'])
        ->can('create', Membership::class);
    Route::delete(
        'companies/{company}/users/{user}',
        [MembershipController::class, 'detroy'],
    )->can('delete', 'member');
});
