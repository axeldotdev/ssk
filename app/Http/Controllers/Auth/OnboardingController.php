<?php

namespace App\Http\Controllers\Auth;

use App\Enums\OnboardingStep;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class OnboardingController extends Controller
{
    public function show(OnboardingStep $onboardingStep): Response
    {
        return Inertia::render('Auth/Onboarding', compact('onboardingStep'));
    }
}
