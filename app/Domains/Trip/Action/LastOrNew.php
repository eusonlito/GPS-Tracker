<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class LastOrNew extends ActionAbstract
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
     * @var ?string
     */
    protected ?string $positionDateUtcAt;

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->device();
        $this->vehicle();
        $this->row();

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
    protected function row(): void
    {
        $this->rowByPrevious();

        if ($this->rowIsValid()) {
            return;
        }

        $this->rowByNext();

        if ($this->rowIsValid()) {
            return;
        }

        $this->rowCreate();
    }

    /**
     * @return void
     */
    protected function rowByPrevious(): void
    {
        $this->row = Model::query()
            ->byDeviceId($this->device->id)
            ->nearToStartUtcAtBefore($this->data['date_utc_at'])
            ->first();
    }

    /**
     * @return void
     */
    protected function rowByNext(): void
    {
        $this->row = Model::query()
            ->byDeviceId($this->device->id)
            ->nearToStartUtcAtNext($this->data['date_utc_at'])
            ->first();
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    protected function rowCreate(): Model
    {
        return $this->row = $this->factory()->action([
            'start_at' => $this->data['date_at'],
            'start_utc_at' => $this->data['date_utc_at'],
            'device_id' => $this->device->id,
            'timezone_id' => $this->data['timezone_id'],
            'vehicle_id' => $this->vehicle->id,
        ])->create();
    }

    /**
     * @return bool
     */
    protected function rowIsValid(): bool
    {
        return $this->row
            && ($this->rowIsValidAfter() || $this->rowIsValidWait());
    }

    /**
     * @return bool
     */
    protected function rowIsValidAfter(): bool
    {
        return (bool)PositionModel::query()
            ->byTripId($this->row->id)
            ->nextToDateUtcAt($this->data['date_utc_at'])
            ->count();
    }

    /**
     * @return bool
     */
    protected function rowIsValidWait(): bool
    {
        $dateUtcAt = $this->rowIsValidWaitDateUtcAt();

        if ($dateUtcAt === null) {
            return true;
        }

        $wait = app('configuration')->int('trip_wait_minutes');

        if (($wait === 0) || ($wait >= $this->rowIsValidWaitMinutes($dateUtcAt))) {
            return true;
        }

        return false;
    }

    /**
     * @return ?string
     */
    protected function rowIsValidWaitDateUtcAt(): ?string
    {
        return PositionModel::query()
            ->byTripId($this->row->id)
            ->nearToDateUtcAt($this->data['date_utc_at'])
            ->value('date_utc_at');
    }

    /**
     * @param string $dateUtcAt
     *
     * @return int
     */
    protected function rowIsValidWaitMinutes(string $dateUtcAt): int
    {
        return (int)abs((strtotime($this->data['date_utc_at']) - strtotime($dateUtcAt)) / 60);
    }
}
