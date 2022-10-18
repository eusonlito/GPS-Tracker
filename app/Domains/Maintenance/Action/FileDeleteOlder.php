<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use Generator;
use App\Services\Filesystem\Directory;

class FileDeleteOlder extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->data();
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['path'] = base_path($this->data['folder']);
        $this->data['time'] = strtotime('-'.$this->data['days'].' days');
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
        return Directory::files($this->data['path'], $this->data['extensions']);
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
