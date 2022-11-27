<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Device\Model\Device as DeviceModel;

class UpdateDevice extends ActionAbstract
{
    /**
     * @return \App\Domains\Alarm\Model\Alarm
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
        $this->data['related'] = DeviceModel::byIds($this->data['related'])->pluck('id')->all();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->devices()->sync($this->data['related']);
    }
}
