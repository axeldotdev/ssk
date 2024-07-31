<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class NewPasswordRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'token' => ['required'],
            'email' => [
                'required', 'string', 'max:255',
                'lowercase', 'email:rfc,dns,spoof',
            ],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }
}
