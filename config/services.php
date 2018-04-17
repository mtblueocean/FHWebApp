<?php

$services = [

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
        'domain' => env('fithabit.com'),
        'secret' => env('4f126621871721dd029009ee5be2d675'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => FitHabit\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'client_id' => env('STRIPE_KEY'),
        'redirect' => env('STRIPE_REDIRECT_URI'),
    ],
];

if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') { // In case of windows server.
    $services['stripe']['key']       = 'pk_test_gzBKWQ1XzvYovh2Ox7enuC7W';
    $services['stripe']['secret']    = 'sk_test_th2NqY6ZybETfOiGhjA3V6bT';
    $services['stripe']['client_id'] = 'pk_test_gzBKWQ1XzvYovh2Ox7enuC7W';
    $services['stripe']['redirect']  = 'http://localhost:8080';
} else {
    $services['stripe']['key']       = 'pk_live_DgYMe7qp2ksF8rR06ioIeAkk';
    $services['stripe']['secret']    = 'sk_live_MS8y9Uan1lY9tpHQZJMjsKEM';
    $services['stripe']['client_id'] = 'pk_live_DgYMe7qp2ksF8rR06ioIeAkk';
    $services['stripe']['redirect']  = 'https://fithabit.io';
}

return $services;