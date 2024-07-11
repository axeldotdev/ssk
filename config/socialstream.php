<?php

use JoelButcher\Socialstream\Features;

return [
    'middleware' => ['web'],
    'prompt' => 'Or Login Via',
    'providers' => [
        'google' => [
            'id' => 'google',
            'name' => 'Google',
            'buttonLabel' => 'Continue with Google',
        ],
        'microsoft' => [
            'id' => 'microsoft',
            'name' => 'Microsoft',
            'buttonLabel' => 'Continue with Microsoft',
        ],
    ],
    'features' => [
        Features::generateMissingEmails(),
        Features::createAccountOnFirstLogin(),
        Features::globalLogin(),
        Features::authExistingUnlinkedUsers(),
        Features::rememberSession(),
        Features::providerAvatars(),
        Features::refreshOAuthTokens(),
    ],
    'home' => '/dashboard',
    'redirects' => [
        'login' => '/dashboard',
        'register' => '/dashboard',
        'login-failed' => '/login',
        'registration-failed' => '/register',
        'provider-linked' => '/user/profile',
        'provider-link-failed' => '/user/profile',
    ],
];
