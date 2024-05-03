<?php

return [
    'curl-cache-clean' => [
        'path' => 'storage/cache/curl',
    ],

    'directory-empty-delete' => [
        'path' => 'storage/logs',
    ],

    'file-delete-old' => [
        'path' => 'storage/logs',
        'extensions' => ['json', 'log', 'zip'],
        'days' => 360,
    ],

    'file-zip' => [
        'path' => 'storage/logs',
        'extensions' => ['json', 'log'],
        'days' => 30,
    ],
];
