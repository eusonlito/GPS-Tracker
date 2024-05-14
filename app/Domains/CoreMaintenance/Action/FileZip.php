<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

use App\Services\Compress\Zip\File as ZipFile;

class FileZip extends ActionAbstract
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
        $this->compress();
    }

    /**
     * @return bool
     */
    protected function enabled(): bool
    {
        return $this->config('path')
            && $this->config('days')
            && $this->config('extensions');
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataPath();
        $this->dataTime();
        $this->dataExtensions();
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
        $this->data['time'] = strtotime('-'.$this->config('days').' days');
    }

    /**
     * @return void
     */
    protected function dataExtensions(): void
    {
        $this->data['extensions'] = $this->config('extensions');
    }

    /**
     * @return void
     */
    protected function compress(): void
    {
        (new ZipFile($this->data['path']))
            ->extensions($this->data['extensions'])
            ->toTime($this->data['time'])
            ->compress();
    }
}
