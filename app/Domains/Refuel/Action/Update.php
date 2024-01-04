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
        $this->row->point = $this->data['point'];
        $this->row->date_at = $this->data['date_at'];
        $this->row->city_id = $this->data['city_id'];
        $this->row->position_id = $this->data['position_id'];
        $this->row->vehicle_id = $this->data['vehicle_id'];

        $this->row->save();
    }
}
