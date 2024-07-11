<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class VerificationPromptController extends Controller
{
    public function __invoke(Request $request): RedirectResponse|Response
    {
        return $request->user()->isVerified()
            ? redirect()->intended(route('dashboard', absolute: false))
            : Inertia::render('Auth/VerifyUser', [
                'status' => session('status'),
                'signMethod' => $request->signMethod ?? 'email',
            ]);
    }
}
