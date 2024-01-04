<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Maintenance\Model\Maintenance
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();
        $this->files();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataUserId();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkVehicle();
    }

    /**
     * @return void
     */
    protected function checkVehicle(): void
    {
        if ($this->checkVehicleExists() === false) {
            $this->exceptionValidator(__('maintenance-create.error.vehicle-not-found'));
        }
    }

    /**
     * @return bool
     */
    protected function checkVehicleExists(): bool
    {
        return VehicleModel::query()
            ->selectOnly('id')
            ->byId($this->data['vehicle_id'])
            ->byUserId($this->data['user_id'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function files(): void
    {
        $this->factory('File')->action($this->filesData())->upload();
    }

    /**
     * @return array
     */
    protected function filesData(): array
    {
        return [
            'files' => $this->request->all('files')['files'],
            'related_table' => $this->row->getTable(),
            'related_id' => $this->row->id,
            'user_id' => $this->data['user_id'],
        ];
    }
}
