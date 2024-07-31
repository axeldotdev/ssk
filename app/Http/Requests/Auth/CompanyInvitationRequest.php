<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class CompanyInvitationRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> */
    public function rules(): array
    {
        return [
            'register_method' => [
                'required', 'string', 'max:255', Rule::in(['email', 'phone']),
            ],
            'country' => ['required', 'string', 'max:255'],
            'locale' => ['required', 'string', 'max:255'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => [
                'required_if:register_method,email', 'string', 'max:255', 'lowercase',
                'email:rfc,dns,spoof', Rule::unique(User::class, 'email'),
            ],
            'phone' => [
                'required_if:register_method,phone', 'string', 'max:255',
            ],
            'password' => [
                'required_without:phone', 'confirmed', Password::defaults(),
            ],
            'terms' => ['required', 'boolean'],
        ];
    }
}
