<?php

namespace App\Http\Controllers\Auth;

use App\Features\SignViaEmail;
use App\Features\SignViaPhone;
use App\Features\SignViaSSO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Pennant\Feature;

class AuthenticatedSessionController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'signViaEmail' => Feature::active(SignViaEmail::class),
            'signViaPhone' => Feature::active(SignViaPhone::class),
            'signViaSSO' => Feature::active(SignViaSSO::class),
            'status' => session('status'),
        ]);
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->user()->update(['current_company_id' => null]);

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
