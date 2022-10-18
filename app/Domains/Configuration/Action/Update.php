<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->key = $this->data['key'];
        $this->row->value = $this->data['value'];
        $this->row->description = $this->data['description'];
        $this->row->updated_at = date('Y-m-d H:i:s');

        $this->row->save();
    }
}
