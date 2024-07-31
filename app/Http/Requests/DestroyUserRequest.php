<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class DestroyUserRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> */
    public function rules(): array
    {
        return [
            'password' => ['required', 'current_password'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->user()->ownedCompanies()->exists()) {
                    $validator->errors()->add(
                        'companies',
                        'You must transfer or delete your owned companies first.',
                    );
                }
            },
        ];
    }
}
