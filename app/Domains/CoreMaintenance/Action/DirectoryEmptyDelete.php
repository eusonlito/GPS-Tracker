<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

class DirectoryEmptyDelete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->data();
        $this->iterate($this->data['path']);
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['path'] = base_path($this->data['folder']);
    }

    /**
     * @param string $directory
     *
     * @return void
     */
    protected function iterate(string $directory): void
    {
        foreach ($this->scan($directory) as $path) {
            if (is_dir($directory.'/'.$path)) {
                $this->iterate($directory.'/'.$path);
            }
        }

        if ($this->directoryIsEmpty($directory)) {
            $this->delete($directory);
        }
    }

    /**
     * @param string $directory
     *
     * @return array
     */
    protected function scan(string $directory): array
    {
        return array_diff(scandir($directory), ['.', '..']);
    }

    /**
     * @param string $directory
     *
     * @return bool
     */
    protected function directoryIsEmpty(string $directory): bool
    {
        return ($directory !== $this->data['path'])
            && empty(array_diff(scandir($directory), ['.', '..']));
    }

    /**
     * @param string $directory
     *
     * @return void
     */
    protected function delete(string $directory): void
    {
        rmdir($directory);
    }
}
