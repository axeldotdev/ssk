<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EmailVerificationNotificationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        if ($request->user()->verified_at !== null) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $request->user()->notify(new VerifyEmail());

        return back()->with('status', 'verification-link-sent');
    }
}
