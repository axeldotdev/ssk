<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> */
    public function rules(): array
    {
        return [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 'string', 'max:255',
                'lowercase', 'email:rfc,dns,spoof',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }
}
