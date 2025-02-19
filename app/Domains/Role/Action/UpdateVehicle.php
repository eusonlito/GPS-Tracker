<?php

declare(strict_types=1);

namespace App\Domains\Role\Action;

use App\Domains\Role\Model\Role as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class UpdateVehicle extends ActionAbstract
{
    /**
     * @return \App\Domains\Role\Model\Role
     */
    public function handle(): Model
    {
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->data['related'] = VehicleModel::query()
            ->byUserId($this->row->user_id)
            ->byIds($this->data['related'])
            ->pluck('id')
            ->all();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->vehicles()->sync($this->data['related']);
    }
}
