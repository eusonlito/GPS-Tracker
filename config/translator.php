<?php
return [
    'provider' => env('TRANSLATOR_PROVIDER'),

    'providers' => [
        'microsoft' => [
            'key' => env('MICROSOFT_AZURE_KEY'),
            'region' => env('MICROSOFT_AZURE_REGION'),
        ],

        'deepl' => [
            'key' => env('DEEPL_KEY'),
        ],
    ],
];
