<?php

namespace App\Http\Controllers\Auth;

use App\Enums\OnboardingStep;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanyOnboardingRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;

class CompanyOnboardingController extends Controller
{
    public function store(CompanyOnboardingRequest $request): RedirectResponse
    {
        $company = Company::updateOrCreate($request->validated(), [
            'user_id' => $request->user()->id,
        ]);

        $request->user()->update([
            'current_company_id' => $company->id,
        ]);

        return redirect()->route('onboarding', [
            'onboardingStep' => OnboardingStep::Collaborators->value,
        ]);
    }
}
