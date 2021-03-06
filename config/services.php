<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
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

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'payjp' => [
        // 単発決済用（基本使わない）
        // 'sk_test' => env('SK_TEST'),
        // 'pk_test' => env('PK_TEST'),
        // 'sk_live' => env('SK_LIVE'),
        // 'pk_live' => env('PK_LIVE'),

        //　プラットフォーム決済用
        'sk_test_p' => env('SK_TEST_P'),
        'pk_test_p' => env('PK_TEST_P'),
        'sk_live_p' => env('SK_LIVE_P'),
        'pk_live_p' => env('PK_LIVE_P'),

    ],

];
