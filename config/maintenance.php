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
        'days' => intval(env('MAINTENANCE_FILE_DELETE_OLD_DAYS', 360)),
    ],

    'file-zip' => [
        'path' => 'storage/logs',
        'extensions' => ['json', 'log'],
        'days' => intval(env('MAINTENANCE_FILE_ZIP_DAYS', 30)),
    ],
];
