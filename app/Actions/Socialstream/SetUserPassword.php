<?php

namespace App\Actions\Socialstream;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use JoelButcher\Socialstream\Contracts\SetsUserPasswords;

class SetUserPassword implements SetsUserPasswords
{
    public function set(mixed $user, array $input): void
    {
        Validator::make($input, [
            'password' => [
                'required',
                'string',
                Password::default(),
                'confirmed',
            ],
        ])->validateWithBag('setPassword');

        $user->forceFill([
            'password' => Hash::make($input['password']),
        ])->save();
    }
}
