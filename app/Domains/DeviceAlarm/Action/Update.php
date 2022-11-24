<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Action;

use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;
use App\Domains\DeviceAlarm\Service\Type\Format\FormatAbstract as TypeFormatAbstract;

class Update extends ActionAbstract
{
    /**
     * @var \App\Domains\DeviceAlarm\Service\Type\Format\FormatAbstract
     */
    protected TypeFormatAbstract $type;

    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    public function handle(): Model
    {
        $this->type();
        $this->check();
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function type(): void
    {
        $this->type = $this->row->typeFormat($this->data['config']);
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkType();
    }

    /**
     * @return void
     */
    protected function checkType(): void
    {
        $this->type->validate();
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
        $this->data['config'] = $this->type->config();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->config = $this->data['config'];
        $this->row->telegram = $this->data['telegram'];
        $this->row->enabled = $this->data['enabled'];

        $this->row->save();
    }
}
