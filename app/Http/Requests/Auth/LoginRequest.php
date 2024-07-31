<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> */
    public function rules(): array
    {
        return [
            'email' => [
                'required_without:phone',
                'string', 'max:255', 'lowercase',
                'email:rfc,dns,spoof',
            ],
            'password' => ['required', 'string', 'max:255'],
            'phone' => [
                'required_without:email',
                'string', 'max:255',
            ],
        ];
    }

    /** @throws \Illuminate\Validation\ValidationException */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $attempt = Auth::attempt(
            $this->filled('email')
                ? $this->only('email', 'password')
                : $this->only('phone', 'password'),
            $this->boolean('remember'),
        );

        if (! $attempt) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /** @throws \Illuminate\Validation\ValidationException */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey(): string
    {
        return Str::transliterate(
            $this->filled('email')
                ? Str::lower($this->string('email')) . '|' . $this->ip()
                : $this->string('phone') . '|' . $this->ip(),
        );
    }
}
