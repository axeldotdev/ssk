<?php

namespace App\Http\Controllers;

use App\Http\Requests\DestroyUserRequest;
use App\Http\Requests\UserRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    public function update(UserRequest $request): RedirectResponse
    {
        $request->user()->update($request->validated());

        return Redirect::route('profile.edit');
    }

    public function destroy(DestroyUserRequest $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();

        $user->connectedAccounts->each->delete();
        $user->updateQuietly(['current_company_id' => null]);
        $user->companies()->detach();
        $user->delete();

        Session::invalidate();
        Session::regenerateToken();

        return Redirect::to('/login');
    }
}
