<?php declare(strict_types=1);

namespace App\Domains\File\Action;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        if (config('demo.enabled')) {
            $this->exceptionValidator(__('demo.error.not-allowed'));
        }

        $this->delete();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->deleteRow();
        $this->deleteFile();
    }

    /**
     * @return void
     */
    protected function deleteRow(): void
    {
        $this->row->delete();
    }

    /**
     * @return void
     */
    protected function deleteFile(): void
    {
        $this->row->fileDelete();
    }
}
