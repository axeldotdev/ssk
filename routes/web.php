<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CurrentCompanyController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TermsOfServiceController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Health\Http\Controllers\HealthCheckResultsController;

Route::get('tools/health', HealthCheckResultsController::class)
    ->can('viewHealth');

Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])
    ->name('terms.show');
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])
    ->name('policy.show');

Route::redirect('/', 'dashboard');

Route::middleware([
    'auth', 'verified', 'onboarded',
    'assigned', 'localized',
])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::get('profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('company', [CurrentCompanyController::class, 'edit'])
        ->name('company.edit');
    Route::put('company', [CurrentCompanyController::class, 'update'])
        ->name('company.update');

    Route::get('tokens', [TokenController::class, 'index'])
        ->name('tokens.index');
    Route::get('tokens/create', [TokenController::class, 'create'])
        ->name('tokens.create');
    Route::post('tokens', [TokenController::class, 'store'])
        ->name('tokens.store');
    Route::delete('tokens/{token}', [TokenController::class, 'destroy'])
        ->name('tokens.destroy');

    Route::get('documentation/get-started', function () {
        return Inertia::render('Documentation/GetStarted');
    })->name('documentation.get-started');

    Route::get('companies', [CompanyController::class, 'index'])
        ->name('companies.index');
    Route::get('companies/create', [CompanyController::class, 'create'])
        ->name('companies.create');
    Route::get('companies/{company}', [CompanyController::class, 'show'])
        ->name('companies.show');
    Route::put('companies/{company}', [CompanyController::class, 'update'])
        ->name('companies.update');
});

require __DIR__ . '/auth.php';
