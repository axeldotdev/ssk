<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PhoneVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyPhoneController extends Controller
{
    public function __invoke(
        PhoneVerificationRequest $request,
    ): RedirectResponse {
        $request->fulfill();

        return redirect()->intended(
            route('dashboard', absolute: false) . '?verified=1',
        );
    }
}
