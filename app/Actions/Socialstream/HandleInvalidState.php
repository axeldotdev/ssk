<?php

namespace App\Actions\Socialstream;

use Illuminate\Http\Response;
use JoelButcher\Socialstream\Contracts\HandlesInvalidState;
use Laravel\Socialite\Two\InvalidStateException;

class HandleInvalidState implements HandlesInvalidState
{
    public function handle(InvalidStateException $exception): Response
    {
        throw $exception;
    }
}
