<?php declare(strict_types=1);

namespace App\Services\Compress\Zip;

use ZipArchive;

class Extract
{
    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $file
     *
     * @return self
     */
    public function __construct(protected string $file)
    {
    }

    /**
     * @param string|array|null $files = null
     *
     * @return void
     */
    public function extract(string|array|null $files = null): void
    {
        $zip = new ZipArchive();

        if ($zip->open($this->file, ZipArchive::RDONLY) !== true) {
            return;
        }

        $zip->extractTo(dirname($this->file), $files);
        $zip->close();
    }
}
