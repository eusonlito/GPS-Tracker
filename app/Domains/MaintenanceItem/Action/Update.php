<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->save();
    }
}
