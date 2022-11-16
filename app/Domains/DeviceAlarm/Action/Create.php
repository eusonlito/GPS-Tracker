<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;
use App\Domains\DeviceAlarm\Service\Type\Manager as TypeManager;
use App\Domains\DeviceAlarm\Service\Type\Format\FormatAbstract as TypeFormatAbstract;

class Create extends ActionAbstract
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
    protected function data(): void
    {
        $this->dataType();
        $this->dataConfig();
        $this->dataDeviceId();
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
    protected function dataDeviceId(): void
    {
        $this->data['device_id'] = DeviceModel::query()
            ->select('id')
            ->byId($this->data['device_id'])
            ->byUserId($this->auth->id)
            ->firstOrFail()
            ->id;
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
            'enabled' => $this->data['enabled'],
            'device_id' => $this->data['device_id'],
        ]);
    }
}
