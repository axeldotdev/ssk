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
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => [
                'required_without:phone', 'string', 'max:255',
                'lowercase', 'email:rfc,dns,spoof',
                Rule::unique(User::class, 'email'),
            ],
            'phone' => [
                'required_without:email',
                'string', 'max:255',
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
