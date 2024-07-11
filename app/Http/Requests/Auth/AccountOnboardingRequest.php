<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AccountOnboardingRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> */
    public function rules(): array
    {
        return [
            'firstname' => ['sometimes', 'string'],
            'lastname' => ['sometimes', 'string'],
            'country' => ['required', 'string'],
            'locale' => ['required', 'string'],
        ];
    }
}
