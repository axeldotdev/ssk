<?php

namespace App\Http\Requests\Auth;

use App\Events\Verified;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;

class PhoneVerificationRequest extends FormRequest
{
    /** @return bool */
    public function authorize()
    {
        return Hash::check($this->string('password'), $this->user()->password);
    }

    /** @return array<string, \Illuminate\Contracts\Validation\Rule|array|string> */
    public function rules()
    {
        return [];
    }

    public function fulfill(): void
    {
        if (! $this->user()->isVerified()) {
            $this->user()->markUserAsVerified();

            event(new Verified($this->user()));
        }
    }

    /** @return \Illuminate\Validation\Validator */
    public function withValidator(Validator $validator)
    {
        return $validator;
    }
}
