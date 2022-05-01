<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
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

    'twilio' => [
        'sid' => env('TWILIO_SID'),
        'token' => env('TWILIO_TOKEN'),
        'from' => env('TWILIO_FROM'),
        'api_key' => env('TWILIO_API_KEY'),
        'api_secret' => env('TWILIO_API_SECRET'),
        'status_callback' => env('TWILIO_CALLBACK_URL'),
        'twilio_test_phone_number' => env('TWILIO_TEST_PHONE_NUMBER'),
    ],

    'stripe' => [
        'api_key' => env('STRIPE_KEY'),
        'api_secret' => env('STRIPE_SECRET_KEY'),
        'api_key_test' => env('STRIPE_KEY_TEST'),
        'api_secret_test' => env('STRIPE_SECRET_KEY_TEST'),
        'client_id' => env('STRIPE_CLIENT_ID'),
    ],
];
