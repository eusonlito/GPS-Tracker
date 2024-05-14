<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

use Generator;
use App\Services\Filesystem\Directory;

class CurlCacheClean extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        if ($this->enabled() === false) {
            return;
        }

        $this->data();
        $this->iterate();
    }

    /**
     * @return bool
     */
    protected function enabled(): bool
    {
        return boolval($this->config('path'));
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataPath();
        $this->dataTime();
    }

    /**
     * @return void
     */
    protected function dataPath(): void
    {
        $this->data['path'] = base_path($this->config('path'));
    }

    /**
     * @return void
     */
    protected function dataTime(): void
    {
        $this->data['time'] = time();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->scan() as $file) {
            $this->file($file);
        }
    }

    /**
     * @return \Generator
     */
    protected function scan(): Generator
    {
        return Directory::files($this->data['path']);
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function file(string $file): void
    {
        if (filemtime($file) < $this->data['time']) {
            $this->delete($file);
        }
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function delete(string $file): void
    {
        unlink($file);
    }
}
