<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->date_at = $this->data['date_at'];
        $this->row->name = $this->data['name'];
        $this->row->workshop = $this->data['workshop'];
        $this->row->amount = $this->data['amount'];
        $this->row->distance = $this->data['distance'];
        $this->row->distance_next = $this->data['distance_next'];
        $this->row->description = $this->data['description'];
        $this->row->vehicle_id = $this->data['vehicle_id'];

        $this->row->save();
    }
}
