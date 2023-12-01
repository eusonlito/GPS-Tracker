<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Trip as Model;

class Create extends ActionAbstract
{
    /**
     * @var \App\Domains\Device\Model\Device
     */
    protected DeviceModel $device;

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->device();
        $this->data();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function device(): void
    {
        $this->device = DeviceModel::query()->findOrFail($this->data['device_id']);
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
        $this->dataSharedPublic();
        $this->dataDeviceId();
        $this->dataUserId();
        $this->dataVehicleId();
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
    protected function dataSharedPublic(): void
    {
        $this->data['shared_public'] = $this->device->shared_public;
    }

    /**
     * @return void
     */
    protected function dataDeviceId(): void
    {
        $this->data['device_id'] = $this->device->id;
    }

    /**
     * @return void
     */
    protected function dataUserId(): void
    {
        $this->data['user_id'] = $this->device->user_id;
    }

    /**
     * @return void
     */
    protected function dataVehicleId(): void
    {
        $this->data['vehicle_id'] = $this->device->vehicle_id;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkTimezoneId();
    }

    /**
     * @return void
     */
    protected function checkTimezoneId(): void
    {
        if ($this->checkTimezoneIdExists() === false) {
            $this->exceptionValidator(__('trip-create.error.timezone_id-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkTimezoneIdExists(): bool
    {
        return TimezoneModel::query()
            ->byId($this->data['timezone_id'])
            ->exists();
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
            'shared_public' => $this->data['shared_public'],
            'device_id' => $this->data['device_id'],
            'timezone_id' => $this->data['timezone_id'],
            'user_id' => $this->data['user_id'],
            'vehicle_id' => $this->data['vehicle_id'],
        ]);
    }
}
