<?php

namespace App\Http\Requests\Auth;

use App\Events\Verified;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class EmailVerificationRequest extends FormRequest
{
    /** @return bool */
    public function authorize()
    {
        if (! hash_equals(
            (string) $this->user()->getKey(),
            (string) $this->route('id'),
        )) {
            return false;
        }

        return ! (! hash_equals(
            sha1($this->user()->getEmailForVerification()),
            (string) $this->route('hash')
        ));
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
