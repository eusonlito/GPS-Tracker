<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Action;

use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'name' => $this->data['name'],
            'user_id' => $this->data['user_id'],
        ])->fresh();
    }
}
