<?php declare(strict_types=1);

namespace App\Domains\File\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->path = $this->data['path'];
        $this->row->size = $this->data['size'];
        $this->row->save();
    }
}
