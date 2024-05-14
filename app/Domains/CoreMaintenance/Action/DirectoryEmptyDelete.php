<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

class DirectoryEmptyDelete extends ActionAbstract
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
    protected function iterate(): void
    {
        $this->iterateRecursive($this->data['path']);
    }

    /**
     * @param string $path
     *
     * @return void
     */
    protected function iterateRecursive(string $path): void
    {
        foreach ($this->scan($path) as $directory) {
            if (is_dir($path.'/'.$directory)) {
                $this->iterateRecursive($path.'/'.$directory);
            }
        }

        if ($this->pathIsEmpty($path)) {
            $this->delete($path);
        }
    }

    /**
     * @param string $path
     *
     * @return array
     */
    protected function scan(string $path): array
    {
        return array_diff(scandir($path), ['.', '..']);
    }

    /**
     * @param string $path
     *
     * @return bool
     */
    protected function pathIsEmpty(string $path): bool
    {
        return ($path !== $this->data['path'])
            && empty(array_diff(scandir($path), ['.', '..']));
    }

    /**
     * @param string $path
     *
     * @return void
     */
    protected function delete(string $path): void
    {
        rmdir($path);
    }
}
