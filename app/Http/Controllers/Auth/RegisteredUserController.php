<?php

namespace App\Http\Controllers\Auth;

use App\Events\Verified;
use App\Features\SignViaEmail;
use App\Features\SignViaPhone;
use App\Features\SignViaSSO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Pennant\Feature;

class RegisteredUserController extends Controller
{
    public function create(): Response
    {
        return Inertia::render('Auth/Register', [
            'signViaEmail' => Feature::active(SignViaEmail::class),
            'signViaPhone' => Feature::active(SignViaPhone::class),
            'signViaSSO' => Feature::active(SignViaSSO::class),
        ]);
    }

    /** @throws \Illuminate\Validation\ValidationException */
    public function store(RegisterRequest $request): RedirectResponse
    {
        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email ?? null,
            'phone' => $request->phone ?? null,
            'password' => Hash::make(
                $request->password ?? random_int(100000, 999999),
            ),
        ]);

        event(new Verified($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
