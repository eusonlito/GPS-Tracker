<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;

class Update extends ActionAbstract
{
    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
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
        $this->dataAlarm();
    }

    /**
     * @return void
     */
    protected function dataAlarm(): void
    {
        $this->data['type'] = trim($this->data['type']);
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->type = $this->data['type'];
        $this->row->config = $this->data['config'];
        $this->row->enabled = $this->data['enabled'];

        $this->row->save();
    }
}
