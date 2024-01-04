<?php declare(strict_types=1);

namespace App\Domains\Refuel\Action;

use App\Domains\Refuel\Model\Refuel as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'distance' => $this->data['distance'],
            'distance_total' => $this->data['distance_total'],
            'quantity' => $this->data['quantity'],
            'quantity_before' => $this->data['quantity_before'],
            'price' => $this->data['price'],
            'total' => $this->data['total'],
            'point' => $this->data['point'],
            'date_at' => $this->data['date_at'],
            'position_id' => $this->data['position_id'],
            'user_id' => $this->data['user_id'],
            'vehicle_id' => $this->data['vehicle_id'],
        ]);
    }
}
