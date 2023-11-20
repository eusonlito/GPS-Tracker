<?php
return [
    'provider' => env('TRANSLATOR_PROVIDER'),

    'providers' => [
        'Microsoft' => [
            'key' => env('MICROSOFT_AZURE_KEY'),
            'region' => env('MICROSOFT_AZURE_REGION'),
        ],

        'DeepL' => [
            'key' => env('DEEPL_KEY'),
        ],

        'OpenAI' => [
            'key' => env('OPENAI_KEY'),
            'model' => env('OPENAI_MODEL', 'gpt-4-1106-preview'),
            'temperature' => env('OPENAI_TEMPERATURE', 0),
        ],
    ],
];
