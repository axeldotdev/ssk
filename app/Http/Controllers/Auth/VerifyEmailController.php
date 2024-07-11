<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    public function __invoke(
        EmailVerificationRequest $request,
    ): RedirectResponse {
        $request->fulfill();

        return redirect()->intended(
            route('dashboard', absolute: false) . '?verified=1',
        );
    }
}
