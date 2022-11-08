<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;

class UpdateDeviceMessageCreate extends ActionAbstract
{
    /**
     * @return \App\Domains\Device\Model\Device
     */
    public function handle(): Model
    {
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->factory('DeviceMessage')->action($this->saveData())->create();
    }

    /**
     * @return array
     */
    protected function saveData(): array
    {
        return ['device_id' => $this->row->id] + $this->request->input();
    }
}
