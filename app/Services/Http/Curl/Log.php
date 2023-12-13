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
        $dir = storage_path('logs/curl/'.date('Y/m/d'));

        $file = preg_replace(['/[^a-zA-Z0-9-]/', '/\-{2,}/'], ['-', '-'], $url);
        $file = date('H-i-s').'-'.sprintf('%.4f', microtime(true)).'-'.$status.'-'.substr($file, 0, 200).'.json';

        helper()->mkdir($dir);

        file_put_contents($dir.'/'.$file, helper()->jsonEncode($data), LOCK_EX);
    }
}
