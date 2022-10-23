<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as Model;

class LastOrNew extends ActionAbstract
{
    /**
     * @var \App\Domains\Device\Model\Device
     */
    protected DeviceModel $device;

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
        $this->row();
        $this->createIfPositionInvalid();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function device(): void
    {
        $this->device = DeviceModel::findOrFail($this->data['device_id']);
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::byDeviceId($this->device->id)
            ->nearToStartUtcAt($this->data['date_utc_at'])
            ->firstOr(fn () => $this->rowCreate());
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
        ])->create();
    }

    /**
     * @return void
     */
    protected function createIfPositionInvalid(): void
    {
        if ($this->positionIsValid() === false) {
            $this->rowCreate();
        }
    }

    /**
     * @return bool
     */
    protected function positionIsValid(): bool
    {
        $dateUtcAt = $this->positionDateUtcAt();

        if ($dateUtcAt === null) {
            return true;
        }

        $wait = app('configuration')->int('trip_wait_minutes');

        if (($wait === 0) || ($wait >= $this->positionMinutes($dateUtcAt))) {
            return true;
        }

        return false;
    }

    /**
     * @return ?string
     */
    protected function positionDateUtcAt(): ?string
    {
        return PositionModel::byTripId($this->row->id)
            ->nearToDateUtcAt($this->data['date_utc_at'])
            ->value('date_utc_at');
    }

    /**
     * @param string $dateUtcAt
     *
     * @return int
     */
    protected function positionMinutes(string $dateUtcAt): int
    {
        return (int)abs((strtotime($this->data['date_utc_at']) - strtotime($dateUtcAt)) / 60);
    }
}
