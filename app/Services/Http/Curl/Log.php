<?php declare(strict_types=1);

namespace App\Services\Http\Curl;

class Log
{
    /**
     * @param string $url
     * @param string $status
     * @param array $data
     *
     * @return void
     */
    public static function write(string $url, string $status, array $data): void
    {
        $dir = storage_path('logs/curl/'.date('Y-m-d'));

        $file = preg_replace(['/[^a-zA-Z0-9-]/', '/\-{2,}/'], ['-', '-'], $url);
        $file = date('H-i-s').'-'.microtime(true).'-'.$status.'-'.substr($file, 0, 200).'.json';

        clearstatcache(true, $dir);

        if (is_dir($dir) === false) {
            mkdir($dir, 0o755, true);
        }

        file_put_contents($dir.'/'.$file, json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_LINE_TERMINATORS | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE |
            JSON_INVALID_UTF8_IGNORE | JSON_INVALID_UTF8_SUBSTITUTE | JSON_PARTIAL_OUTPUT_ON_ERROR
        ), LOCK_EX);
    }
}
