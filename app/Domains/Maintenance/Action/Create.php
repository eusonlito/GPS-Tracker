<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Model\Maintenance as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'date_at' => $this->data['date_at'],
            'name' => $this->data['name'],
            'workshop' => $this->data['workshop'],
            'amount' => $this->data['amount'],
            'distance' => $this->data['distance'],
            'distance_next' => $this->data['distance_next'],
            'description' => $this->data['description'],
            'user_id' => $this->data['user_id'],
            'vehicle_id' => $this->data['vehicle_id'],
        ]);
    }
}
