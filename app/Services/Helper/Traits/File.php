<?php declare(strict_types=1);

namespace App\Services\Helper\Traits;

use Exception;

trait File
{
    /**
     * @param string $dir
     * @param bool $file = false
     *
     * @return string
     */
    public function mkdir(string $dir, bool $file = false): string
    {
        if ($file) {
            $dir = dirname($dir);
        }

        clearstatcache(true, $dir);

        if (is_dir($dir)) {
            return $dir;
        }

        try {
            mkdir($dir, 0o755, true);
        } catch (Exception $e) {
            report($e);
        }

        return $dir;
    }

    /**
     * @param string $file
     * @param string $contents
     *
     * @return void
     */
    public function filePutContents(string $file, string $contents): void
    {
        $this->mkdir($file, true);

        file_put_contents($file, $contents, LOCK_EX);
    }
}
