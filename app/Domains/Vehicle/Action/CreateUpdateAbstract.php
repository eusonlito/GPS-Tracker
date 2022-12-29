<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Action;

use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Vehicle\Model\Vehicle as Model;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function data(): void;

    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Vehicle\Model\Vehicle
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
    protected function dataName(): void
    {
        $this->data['name'] = trim($this->data['name']);
    }

    /**
     * @return void
     */
    protected function dataPlate(): void
    {
        $this->data['plate'] = trim($this->data['plate']);
    }

    /**
     * @return void
     */
    protected function dataTimezoneId(): void
    {
        $this->data['timezone_id'] = TimezoneModel::query()
            ->selectOnly('id')
            ->findOrFail($this->data['timezone_id'])
            ->id;
    }
}
