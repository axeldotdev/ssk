<?php

namespace App\Http\Middleware;

use App\Features\VerifyUser;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Laravel\Pennant\Feature;

class EnsureUserIsVerified
{
    public function handle(
        Request $request,
        Closure $next,
    ): Response|RedirectResponse|JsonResponse|null {
        if (! $request->user() ||
            (Feature::active(VerifyUser::class) &&
            ! $request->user()->isVerified())) {
            return $request->expectsJson()
                ? abort(403, 'Your account is not verified.')
                : Redirect::guest(URL::route('verification.notice', [
                    'signMethod' => ! is_null($request->user()->email)
                        ? 'email'
                        : 'phone',
                ]));
        }

        return $next($request);
    }
}
