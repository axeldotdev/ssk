<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ConnectedAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ConnectedAccountController extends Controller
{
    public function destroy(Request $request, string|int $id): RedirectResponse
    {
        $request->validateWithBag('connectedAccountRemoval', [
            'password' => ['required', 'current_password'],
        ]);

        ConnectedAccount::query()
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->delete();

        return back()->with('status', 'connected-account-removed');
    }
}
