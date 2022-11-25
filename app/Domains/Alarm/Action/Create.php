<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Alarm\Service\Type\Manager as TypeManager;
use App\Domains\Alarm\Service\Type\Format\FormatAbstract as TypeFormatAbstract;

class Create extends ActionAbstract
{
    /**
     * @var \App\Domains\Alarm\Service\Type\Format\FormatAbstract
     */
    protected TypeFormatAbstract $type;

    /**
     * @return \App\Domains\Alarm\Model\Alarm
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
        $this->type = TypeManager::new()->factory($this->data['type'], $this->data['config']);
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
        $this->dataType();
        $this->dataConfig();
    }

    /**
     * @return void
     */
    protected function dataType(): void
    {
        $this->data['type'] = $this->type->code();
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
        $this->row = Model::create([
            'type' => $this->data['type'],
            'name' => $this->data['name'],
            'config' => $this->data['config'],
            'telegram' => $this->data['enabled'],
            'enabled' => $this->data['enabled'],
        ]);
    }
}
