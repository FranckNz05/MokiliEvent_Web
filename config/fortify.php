<?php

use Laravel\Fortify\Features;

return [
    'guard' => 'web',
    'middleware' => ['web'],
    'auth_middleware' => 'auth',
    'passwords' => 'users',
    'username' => 'email',
    'email' => 'email',
    'views' => true,
    'home' => '/dashboard',
    'prefix' => '',
    'domain' => null,
    'limiters' => [
        'login' => null,
    ],
    'paths' => [
        'login' => 'connexion',
        'logout' => 'deconnexion',
        'register' => 'inscription',
        'password.request' => 'mot-de-passe/reinitialiser',
        'password.reset' => 'mot-de-passe/reinitialiser/{token}',
        'password.email' => 'mot-de-passe/email',
        'password.update' => 'mot-de-passe/update',
    ],
    'redirects' => [
        'login' => 'auth.login',
        'logout' => 'home',
        'password-confirmation' => null,
        'register-complete' => null,
        'email-verification-complete' => null,
    ],
    'features' => [
        Features::registration(),
        Features::resetPasswords(),
        Features::emailVerification(),
        Features::updateProfileInformation(),
        Features::updatePasswords(),
        Features::twoFactorAuthentication(),
    ],
];
