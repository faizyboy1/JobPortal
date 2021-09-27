<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    | If you're using API credentials, change these settings. Get your
    | credentials from https://dashboard.nexmo.com | 'Settings'.
    |
    */

    'api_key'    => function_exists('env') ? env('NEXMO_KEY', '') : '',
    'api_secret' => function_exists('env') ? env('NEXMO_SECRET', '') : '',

    /*
    |--------------------------------------------------------------------------
    | Signature Secret
    |--------------------------------------------------------------------------
    |
    | If you're using a signature secret, use this section. This can be used
    | without an `api_secret` for some APIs, as well as with an `api_secret`
    | for all APIs.
    |
    */

    'signature_secret' => function_exists('env') ? env('NEXMO_SIGNATURE_SECRET', '') : '',

    /*
    |--------------------------------------------------------------------------
    | Private Key
    |--------------------------------------------------------------------------
    |
    | Private keys are used to generate JWTs for authentication. Generation is
    | handled by the library. JWTs are required for newer APIs, such as voice
    | and media
    |
    */

    'private_key' => function_exists('env') ? env('NEXMO_PRIVATE_KEY', '') : '',
    'application_id' => function_exists('env') ? env('NEXMO_APPLICATION_ID', '') : '',

    /*
    |--------------------------------------------------------------------------
    | Application Identifiers
    |--------------------------------------------------------------------------
    |
    | Add an application name and version here to identify your application when
    | making API calls
    |
    */

    'app' => ['name' => function_exists('env') ? env('NEXMO_APP_NAME', 'NexmoLaravel') : 'NexmoLaravel',
        'version' => function_exists('env') ? env('NEXMO_APP_VERSION', '1.1.2') : '1.1.2'],

    /*
    |--------------------------------------------------------------------------
    | Settings
    |--------------------------------------------------------------------------
    |
    | Change settings for nexmo verify API
    */
    'settings' => [
        'workflow_id' => 5, // visit https://developer.nexmo.com/verify/guides/workflows-and-events for more info
        'pin_expiry' => 300,    // seconds before the pin code expires
        'next_event_wait' => 150,   // time between different events of workflow SMS->TTL
                                    // check https://developer.nexmo.com/verify/guides/changing-default-timings for more info
        'code_length' => 4, // The length of the verification code. MUST BE 4 OR 6
        'lg' => 'en-us',    // Default language for verification SMS and call
    ]
];
