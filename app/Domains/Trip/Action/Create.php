<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Trip as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class Create extends ActionAbstract
{
    /**
     * @var \App\Domains\Device\Model\Device
     */
    protected DeviceModel $device;

    /**
     * @var \App\Domains\Vehicle\Model\Vehicle
     */
    protected VehicleModel $vehicle;

    /**
     * @var \App\Domains\Timezone\Model\Timezone
     */
    protected TimezoneModel $timezone;

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->device();
        $this->vehicle();
        $this->timezone();
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function device(): void
    {
        $this->device = DeviceModel::query()
            ->findOrFail($this->data['device_id']);
    }

    /**
     * @return void
     */
    protected function vehicle(): void
    {
        $this->vehicle = $this->device->vehicle;
    }

    /**
     * @return void
     */
    protected function timezone(): void
    {
        $this->timezone = TimezoneModel::query()
            ->findOrFail($this->data['timezone_id']);
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataCode();
        $this->dataName();
        $this->dataEndAt();
        $this->dataEndUtcAt();
        $this->dataShared();
    }

    /**
     * @return void
     */
    protected function dataCode(): void
    {
        $this->data['code'] = $this->row?->code ?: helper()->uuid();
    }

    /**
     * @return void
     */
    protected function dataName(): void
    {
        $this->data['name'] = $this->data['name'] ?: $this->data['start_at'];
    }

    /**
     * @return void
     */
    protected function dataEndAt(): void
    {
        $this->data['end_at'] = $this->data['end_at'] ?: $this->data['start_at'];
    }

    /**
     * @return void
     */
    protected function dataEndUtcAt(): void
    {
        $this->data['end_utc_at'] = $this->data['end_utc_at'] ?: $this->data['start_utc_at'];
    }

    /**
     * @return void
     */
    protected function dataShared(): void
    {
        $this->data['shared'] = $this->device->shared;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'code' => $this->data['code'],
            'name' => $this->data['name'],
            'start_at' => $this->data['start_at'],
            'start_utc_at' => $this->data['start_utc_at'],
            'end_at' => $this->data['end_at'],
            'end_utc_at' => $this->data['end_utc_at'],
            'shared' => $this->data['shared'],
            'device_id' => $this->device->id,
            'timezone_id' => $this->timezone->id,
            'user_id' => $this->device->user_id,
            'vehicle_id' => $this->vehicle->id,
        ]);
    }
}
