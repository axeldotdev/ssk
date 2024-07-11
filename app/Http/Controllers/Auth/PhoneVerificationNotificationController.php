<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyPhoneRequest;
use App\Models\User;
use App\Notifications\VerifyPhone;
use Illuminate\Http\RedirectResponse;

class PhoneVerificationNotificationController extends Controller
{
    public function store(VerifyPhoneRequest $request): RedirectResponse
    {
        $user = $request->user() ?? User::query()
            ->where('phone', str($request->phone)->replace(' ', ''))
            ->firstOrFail();

        if ($user->isVerified()) {
            return redirect()->intended(route('dashboard', absolute: false));
        }

        $verificationCode = random_int(100000, 999999);

        $user->update(['password' => $verificationCode]);

        $user->notify(new VerifyPhone($verificationCode));

        return back()->with('status', 'verification-link-sent');
    }
}
