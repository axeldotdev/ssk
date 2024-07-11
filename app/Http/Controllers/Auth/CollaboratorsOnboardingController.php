<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CollaboratorsOnboardingRequest;
use Illuminate\Http\RedirectResponse;

class CollaboratorsOnboardingController extends Controller
{
    public function store(
        CollaboratorsOnboardingRequest $request,
    ): RedirectResponse {
        $request->user()->currentCompany->inviteCollaborators($request->emails);

        $request->user()->markUserAsOnboarded();

        return redirect()->route('dashboard');
    }
}
