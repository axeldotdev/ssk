<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string'],
            'lastname' => ['required', 'string'],
            'email' => [
                'required_without:phone', 'string', 'lowercase',
                'email:rfc,dns,spoof',
                Rule::unique(User::class, 'email'),
            ],
            'phone' => [
                'required_without:email',
                'string',
                Rule::unique(User::class, 'phone'),
            ],
            'password' => [
                'required_without:phone', 'confirmed',
                Password::defaults(),
            ],
            'terms' => ['required', 'boolean'],
        ];
    }
}
