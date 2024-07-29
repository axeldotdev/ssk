<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasskeyRequest;
use App\Models\Passkey;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Throwable;
use Webauthn\AttestationStatement\AttestationStatementSupportManager;
use Webauthn\AuthenticatorAttestationResponse;
use Webauthn\AuthenticatorAttestationResponseValidator;
use Webauthn\Denormalizer\WebauthnSerializerFactory;
use Webauthn\PublicKeyCredential;

class PasskeyController extends Controller
{
    public function store(PasskeyRequest $request)
    {
        /** @var PublicKeyCredential $publicKeyCredential */
        $publicKeyCredential = (new WebauthnSerializerFactory(
            AttestationStatementSupportManager::create(),
        ))
            ->create()
            ->deserialize(
                $request->input('passkey'),
                PublicKeyCredential::class,
                'json',
            );

        if (! $publicKeyCredential->response
            instanceof AuthenticatorAttestationResponse) {
            return Redirect::route('login');
        }

        try {
            $publicKeyCredentialSource = AuthenticatorAttestationResponseValidator::create()->check(
                authenticatorAttestationResponse: $publicKeyCredential->response,
                publicKeyCredentialCreationOptions: Session::get('passkey-options'),
                host: $request->getHost(),
            );
        } catch (Throwable $exception) {
            throw ValidationException::withMessages([
                'name' => $exception->getMessage(),
            ]);
        }

        $request->user()->passkeys()->create([
            'name' => $request->input('name'),
            'credential_id' => $publicKeyCredentialSource->publicKeyCredentialId,
            'data' => $publicKeyCredentialSource,
        ]);

        return Redirect::route('profile.edit');
    }

    public function destroy(Passkey $passkey)
    {
        $passkey->delete();

        return Redirect::route('profile.edit');
    }
}
