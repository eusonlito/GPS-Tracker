<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Services\Compress\Zip\File as ZipFile;

class FileZip extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->data();
        $this->compress();
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
    protected function compress(): void
    {
        (new ZipFile($this->data['path']))
            ->extensions($this->data['extensions'])
            ->toTime($this->data['time'])
            ->compress();
    }
}
