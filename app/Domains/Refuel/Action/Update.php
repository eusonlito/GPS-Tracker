<?php declare(strict_types=1);

namespace App\Domains\Refuel\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->distance = $this->data['distance'];
        $this->row->distance_total = $this->data['distance_total'];
        $this->row->quantity = $this->data['quantity'];
        $this->row->quantity_before = $this->data['quantity_before'];
        $this->row->price = $this->data['price'];
        $this->row->total = $this->data['total'];
        $this->row->date_at = $this->data['date_at'];
        $this->row->vehicle_id = $this->vehicle->id;

        $this->row->save();
    }
}
