<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Action;

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
        $this->dataConfig();
    }

    /**
     * @return void
     */
    protected function dataConfig(): void
    {
        $this->data['config'] = $this->row->typeFormat($this->data['config'])->config();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->config = $this->data['config'];
        $this->row->enabled = $this->data['enabled'];

        $this->row->save();
    }
}
