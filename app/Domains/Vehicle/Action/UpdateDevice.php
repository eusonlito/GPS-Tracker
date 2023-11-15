<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Vehicle\Model\Vehicle as Model;

class UpdateDevice extends ActionAbstract
{
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
    protected function data(): void
    {
        $this->data['related'] = DeviceModel::query()
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
        $this->saveUnrelate();
        $this->saveRelate();
    }

    /**
     * @return void
     */
    protected function saveUnrelate(): void
    {
        DeviceModel::query()
            ->byVehicleId($this->row->id)
            ->update(['vehicle_id' => null]);
    }

    /**
     * @return void
     */
    protected function saveRelate(): void
    {
        if (empty($this->data['related'])) {
            return;
        }

        DeviceModel::query()
            ->byIds($this->data['related'])
            ->update(['vehicle_id' => $this->row->id]);
    }
}
