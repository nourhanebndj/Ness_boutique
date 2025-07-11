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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
   'laposte' => [
    'api_key' => env('LAPOSTE_API_KEY'),
],

    'mypos' => [
    'sid' => env('MYPOS_SID'),
    'wallet' => env('MYPOS_WALLET'),
    'key_path' => env('MYPOS_KEY_PATH'),
    'cert_path' => env('MYPOS_CERT_PATH'),
    'gateway_url' => env('MYPOS_GATEWAY_URL'),
    'callback_url' => env('MYPOS_CALLBACK_URL'),
    'success_url' => env('MYPOS_SUCCESS_URL'),
    'cancel_url' => env('MYPOS_CANCEL_URL'),
],



];