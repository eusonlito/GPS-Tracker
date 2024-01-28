<?php declare(strict_types=1);

namespace App\Services\Compress\Zip;

use Exception;
use ZipArchive;
use App\Services\Filesystem\Directory;

class Folder
{
    /**
     * @var string
     */
    protected string $source;

    /**
     * @var string
     */
    protected string $target;

    /**
     * @var \ZipArchive
     */
    protected ZipArchive $zip;

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
     * @param string $source
     * @param string $source = ''
     *
     * @return self
     */
    public function __construct(string $source, string $target = '')
    {
        $this->source = $this->source($source);
        $this->target = $this->target($target ?: $source);
    }

    /**
     * @param array $extensions
     *
     * @return self
     */
    public function extensions(array $extensions): self
    {
        $this->extensions = $extensions;

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
        $this->open();

        foreach (Directory::files($this->source, $this->compressInclude(), $this->compressExclude()) as $file) {
            $this->file($file);
        }

        $this->close();

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
     * @return ?string
     */
    public function compressExclude(): ?string
    {
        if (empty($this->exclude)) {
            return null;
        }

        return '/\.('.implode('|', $this->exclude).')$/';
    }

    /**
     * @param string $source
     *
     * @return string
     */
    protected function source(string $source): string
    {
        if (str_starts_with($source, '/') === false) {
            $source = base_path($source);
        }

        if (is_dir($source) === false) {
            throw new Exception(sprintf('Folder %s is not a valid source', $source));
        }

        return $source;
    }

    /**
     * @param string $target
     *
     * @return string
     */
    protected function target(string $target): string
    {
        if (is_dir($target)) {
            $target = rtrim($target, '/').'.zip';
        }

        if (str_starts_with($target, '/') === false) {
            $target = base_path($target);
        }

        Directory::create($target, true);

        return $target;
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function file(string $file): void
    {
        if ($this->fileIsValid($file)) {
            $this->addFile($file);
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
     * @return void
     */
    protected function open(): void
    {
        $this->zip = new ZipArchive();
        $this->zip->open($this->target, ZipArchive::CREATE);
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function addFile(string $file): void
    {
        $this->zip->addFile($file, str_replace($this->source, '', $file));
    }

    /**
     * @return void
     */
    protected function close(): void
    {
        $this->zip->close();
    }
}
