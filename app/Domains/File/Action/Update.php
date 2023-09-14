<?php declare(strict_types=1);

namespace App\Domains\File\Action;

use App\Domains\File\Model\File as Model;

class Update extends ActionAbstract
{
    /**
     * @return \App\Domains\File\Model\File
     */
    public function handle(): Model
    {
        $this->delete();
        $this->create();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->factory()->action()->delete();
    }

    /**
     * @return void
     */
    protected function create(): void
    {
        $this->row = $this->factory()->action($this->createData())->create();
    }

    /**
     * @return array
     */
    protected function createData(): array
    {
        return [
            'related_table' => $this->row->related_table,
            'related_id' => $this->row->related_id,
            'file' => $this->data['file'],
        ];
    }
}
