<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CompanyInvitationRequest;
use App\Models\Company;
use App\Models\CompanyInvitation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;

class CompanyInvitationController extends Controller
{
    public function show(
        Company $company,
        CompanyInvitation $invitation,
    ): Response {
        return inertia('Auth/CompanyInvitation', [
            'company' => $company,
            'invitation' => $invitation,
        ]);
    }

    public function update(
        Company $company,
        CompanyInvitation $invitation,
        CompanyInvitationRequest $request,
    ): RedirectResponse {
        $user = User::create([
            ...$request->validated(),
            'verified_at' => now(),
            'onboarded_at' => now(),
            'current_company_id' => $company->id,
        ]);
        $company->users()->attach($user);
        $invitation->delete();

        return redirect()->route('dashboard');
    }
}
