<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;

class Create extends CreateUpdateAbstract
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
        $this->row = Model::query()->create([
            'name' => $this->data['name'],
            'maker' => $this->data['maker'],
            'serial' => $this->data['serial'],
            'phone_number' => $this->data['phone_number'],
            'password' => $this->data['password'],
            'enabled' => $this->data['enabled'],
            'vehicle_id' => $this->data['vehicle_id'],
            'user_id' => $this->auth->id,
        ]);
    }
}
