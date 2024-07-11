<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CollaboratorsOnboardingRequest extends FormRequest
{
    /** @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> */
    public function rules(): array
    {
        $user = $this->user()->current_company_id;

        return [
            'emails' => ['required_without:phone', 'array'],
            'emails.*' => [
                'required', 'string', 'lowercase', 'unique:users,email',
                Rule::unique('company_invitations', 'email')
                    ->where(fn ($query) => $query->where('company_id', $user)),
                'email:rfc,dns,spoof',
            ],
            'phone' => ['required_without:email', 'array'],
            'phone.*' => [
                'required', 'string', 'lowercase', 'unique:users,phone',
                Rule::unique('company_invitations', 'phone')
                    ->where(fn ($query) => $query->where('company_id', $user)),
            ],
        ];
    }
}
