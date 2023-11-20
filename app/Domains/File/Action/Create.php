<?php declare(strict_types=1);

namespace App\Domains\File\Action;

use App\Domains\File\Model\File as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row = Model::query()->create([
            'name' => $this->data['name'],
            'path' => $this->data['path'],
            'size' => $this->data['size'],
            'related_table' => $this->data['related_table'],
            'related_id' => $this->data['related_id'],
            'user_id' => $this->data['user_id'],
        ])->fresh();
    }
}
