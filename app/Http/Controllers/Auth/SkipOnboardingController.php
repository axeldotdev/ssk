<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SkipOnboardingController extends Controller
{
    public function show(Request $request): RedirectResponse
    {
        $request->user()->markUserAsOnboarded();

        return redirect()->route('dashboard');
    }
}
