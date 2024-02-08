<?php declare(strict_types=1);

namespace App\Services\Compress\Zip;

use ZipArchive;

class Contents
{
    /**
     * @var \ZipArchive
     */
    protected ZipArchive $zip;

    /**
     * @var bool
     */
    protected bool $open;

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
        $this->open();
    }

    /**
     * @return void
     */
    protected function open(): void
    {
        $this->zip = new ZipArchive();
        $this->open = $this->zip->open($this->file, ZipArchive::RDONLY);
    }

    /**
     * @param int $index = 0
     *
     * @return ?string
     */
    public function contents(int $index = 0): ?string
    {
        if ($this->contentsIsValid($index) === false) {
            return null;
        }

        return $this->zip->getFromIndex($index);
    }

    /**
     * @param int $index
     *
     * @return bool
     */
    protected function contentsIsValid(int $index): bool
    {
        return $this->open
            && ($index >= 0)
            && ($index < $this->zip->numFiles);
    }
}
