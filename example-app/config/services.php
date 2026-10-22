<?php

return [
    'recaptcha' => ['enabled'=>env('RECAPTCHA_ENABLED',false), 'site_key'=>env('RECAPTCHA_SITE_KEY'), 'secret'=>env('RECAPTCHA_SECRET_KEY'),
        'type'=>env('RECAPTCHA_TYPE','v2'), 'minimum_score'=>(float)env('RECAPTCHA_MINIMUM_SCORE',0.5)],
    'google_maps' => ['browser_key' => env('GOOGLE_MAPS_BROWSER_KEY')],
    'support_ai' => ['enabled' => env('SUPPORT_AI_ENABLED', false), 'key' => env('OPENAI_API_KEY'),
        'model' => env('SUPPORT_AI_MODEL', 'gpt-4.1-mini'), 'daily_limit' => env('SUPPORT_AI_DAILY_LIMIT', 100)],
    'stripe' => ['enabled' => env('PAYMENTS_ENABLED', true), 'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', env('STRIPE_WEBHOOK'))],

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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
