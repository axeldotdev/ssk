<?php

namespace App\Http\Controllers\Auth;

use App\Enums\OnboardingStep;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AccountOnboardingRequest;
use Illuminate\Http\RedirectResponse;

class AccountOnboardingController extends Controller
{
    public function store(AccountOnboardingRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        return redirect()->route('onboarding', [
            'onboardingStep' => OnboardingStep::Company->value,
        ]);
    }
}
