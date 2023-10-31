<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'code' => $this->data['code'],
            'name' => $this->data['name'],
            'model' => $this->data['model'],
            'serial' => $this->data['serial'],
            'phone_number' => $this->data['phone_number'],
            'password' => $this->data['password'],
            'enabled' => $this->data['enabled'],
            'shared' => $this->data['shared'],
            'shared_public' => $this->data['shared_public'],
            'vehicle_id' => $this->data['vehicle_id'],
            'user_id' => $this->data['user_id'],
        ]);
    }
}
