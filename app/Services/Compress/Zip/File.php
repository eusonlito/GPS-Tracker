<?php declare(strict_types=1);

namespace App\Services\Compress\Zip;

use ZipArchive;
use App\Services\Filesystem\Directory;

class File
{
    /**
     * @var string
     */
    protected string $folder;

    /**
     * @var array
     */
    protected array $extensions = [];

    /**
     * @var array
     */
    protected array $exclude = [];

    /**
     * @var int
     */
    protected int $fromTime = 0;

    /**
     * @var int
     */
    protected int $toTime = 0;

    /**
     * @param string $folder
     *
     * @return self
     */
    public function __construct(string $folder)
    {
        $this->folder = $folder;
    }

    /**
     * @param array|string $extensions
     *
     * @return self
     */
    public function extensions(array|string $extensions): self
    {
        $this->extensions = (array)$extensions;

        return $this;
    }

    /**
     * @param array $exclude
     *
     * @return self
     */
    public function exclude(array $exclude): self
    {
        $this->exclude = $exclude;

        return $this;
    }

    /**
     * @param string $date
     *
     * @return self
     */
    public function fromDate(string $date): self
    {
        $this->fromTime = strtotime($date);

        return $this;
    }

    /**
     * @param string $date
     *
     * @return self
     */
    public function toDate(string $date): self
    {
        $this->toTime = strtotime($date);

        return $this;
    }

    /**
     * @param int $time
     *
     * @return self
     */
    public function fromTime(int $time): self
    {
        $this->fromTime = $time;

        return $this;
    }

    /**
     * @param int $time
     *
     * @return self
     */
    public function toTime(int $time): self
    {
        $this->toTime = $time;

        return $this;
    }

    /**
     * @return self
     */
    public function compress(): self
    {
        foreach (Directory::files($this->folder, $this->compressInclude(), $this->compressExclude()) as $file) {
            $this->file($file);
        }

        return $this;
    }

    /**
     * @return ?string
     */
    public function compressInclude(): ?string
    {
        if (empty($this->extensions)) {
            return null;
        }

        return '/\.('.implode('|', $this->extensions).')$/i';
    }

    /**
     * @return string
     */
    public function compressExclude(): string
    {
        return '/('.implode('|', array_filter(array_unique(array_merge($this->exclude, ['\.zip$'])))).')/';
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function file(string $file): void
    {
        if ($this->fileIsValid($file)) {
            $this->pack($file);
        }
    }

    /**
     * @param string $file
     *
     * @return bool
     */
    protected function fileIsValid(string $file): bool
    {
        $time = filemtime($file);

        return (($this->fromTime === 0) || ($time >= $this->fromTime))
            && (($this->toTime === 0) || ($time <= $this->toTime));
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function pack(string $file): void
    {
        $zip = new ZipArchive();

        if ($zip->open($file.'.zip', ZipArchive::CREATE) !== true) {
            return;
        }

        $zip->addFile($file, basename($file));

        if ($zip->close()) {
            unlink($file);
        }
    }
}
