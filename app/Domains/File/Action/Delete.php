<?php declare(strict_types=1);

namespace App\Domains\File\Action;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
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
