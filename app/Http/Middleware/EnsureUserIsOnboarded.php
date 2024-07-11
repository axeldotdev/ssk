<?php

namespace App\Http\Middleware;

use App\Features\OnboardUser;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Laravel\Pennant\Feature;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsOnboarded
{
    public function handle(
        Request $request,
        Closure $next,
    ): Response|RedirectResponse|null {
        if (! $request->user() ||
            (Feature::active(OnboardUser::class) &&
            ! $request->user()->isOnboarded())) {
            return $request->expectsJson()
                ? abort(403, 'Your account is not verified.')
                : Redirect::route(
                    'onboarding',
                    'account',
                );
        }

        return $next($request);
    }
}
