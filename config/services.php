<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => \App\Models\Core\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID', '808006414388-5gc46vp6579vokighme0ms1gju52akep.apps.googleusercontent.com'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET', 'nyDku0OqRWwNNGoJskYNGgdw'),
        'redirect' => env('GOOGLE_REDIRECT_URL'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', '444393819484232'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', '49945e9d4b0a566a4ffcdf4676045e7c'),
        'redirect' => env('FACEBOOK_REDIRECT_URL'),
    ],

    'vkontakte' => [
        'client_id' => env('VKONTAKTE_CLIENT_ID', '7121174'),
        'client_secret' => env('VKONTAKTE_CLIENT_SECRET', 'Ryo6fCTxE8mTDPP5uf5w'),
        'redirect' => env('VKONTAKTE_REDIRECT_URL'),
    ],

];
