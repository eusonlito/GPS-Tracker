<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Device\Model\Device as DeviceModel;
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
        $this->row = $this->rowByNearEndUtcAtMinutes()
            ?: $this->rowByNearEndUtcAt()
            ?: $this->rowCreate();
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    protected function rowByNearEndUtcAtMinutes(): ?Model
    {
        $waitMinutes = $this->waitMinutes();

        if ($waitMinutes === 0) {
            return null;
        }

        return Model::query()
            ->byDeviceId($this->device->id)
            ->byEndUtcAtNearestMinutes($this->data['date_utc_at'], $waitMinutes)
            ->first();
    }

    /**
     * @return ?\App\Domains\Trip\Model\Trip
     */
    protected function rowByNearEndUtcAt(): ?Model
    {
        $waitMinutes = $this->waitMinutes();

        if ($waitMinutes) {
            return null;
        }

        return Model::query()
            ->byDeviceId($this->device->id)
            ->orderByEndUtcAtNearest($this->data['date_utc_at'])
            ->first();
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    protected function rowCreate(): Model
    {
        return $this->factory()->action($this->rowCreateData())->create();
    }

    /**
     * @return array
     */
    protected function rowCreateData(): array
    {
        return [
            'start_at' => $this->data['date_at'],
            'start_utc_at' => $this->data['date_utc_at'],
            'device_id' => $this->device->id,
            'timezone_id' => $this->data['timezone_id'],
            'vehicle_id' => $this->vehicle->id,
        ];
    }

    /**
     * @return int
     */
    protected function waitMinutes(): int
    {
        return app('configuration')->int('trip_wait_minutes');
    }
}
