<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

class Update extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataName();
        $this->dataMaker();
        $this->dataSerial();
        $this->dataPassword();
        $this->dataVehicleId();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkSerial();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->maker = $this->data['maker'];
        $this->row->serial = $this->data['serial'];
        $this->row->phone_number = $this->data['phone_number'];
        $this->row->password = $this->data['password'];
        $this->row->enabled = $this->data['enabled'];
        $this->row->vehicle_id = $this->data['vehicle_id'];

        $this->row->save();
    }
}
