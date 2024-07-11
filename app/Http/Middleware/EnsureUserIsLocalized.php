<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLocalized
{
    public function handle(
        Request $request,
        Closure $next,
    ): Response|RedirectResponse|null {
        app()->setLocale(
            $request->user()->locale->value ?? config('app.locale'),
        );

        return $next($request);
    }
}
