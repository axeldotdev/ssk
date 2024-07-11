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
                'required', 'string', Rule::in(['email', 'phone']),
            ],
            'country' => ['required', 'string'],
            'locale' => ['required', 'string'],
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'email' => [
                'required_if:register_method,email', 'string', 'lowercase',
                'email:rfc,dns,spoof', Rule::unique(User::class),
            ],
            'phone' => [
                'required_if:register_method,phone', 'string',
            ],
            'password' => [
                'required_without:phone', 'confirmed', Password::defaults(),
            ],
            'terms' => ['required', 'boolean'],
        ];
    }
}
