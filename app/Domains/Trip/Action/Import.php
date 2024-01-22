<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use Throwable;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Trip as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;
use App\Services\Gpx\Read as GpxService;

class Import extends ActionAbstract
{
    /**
     * @var array
     */
    protected array $points = [];

    /**
     * @var \App\Domains\Timezone\Model\Timezone
     */
    protected TimezoneModel $timezone;

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->timezone();
        $this->data();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function timezone(): void
    {
        if ($this->data['timezone_id']) {
            $this->timezoneById();
        } else {
            $this->timezoneByVehicle();
        }
    }

    /**
     * @return void
     */
    protected function timezoneById(): void
    {
        $this->timezone = TimezoneModel::query()
            ->selectOnly('id', 'zone')
            ->byId($this->data['timezone_id'])
            ->firstOr(fn () => $this->exceptionValidator(__('trip-import.error.timezone_id-exists')));
    }

    /**
     * @return void
     */
    protected function timezoneByVehicle(): void
    {
        $this->timezone = TimezoneModel::query()
            ->selectOnly('id', 'zone')
            ->byVehicleId($this->data['vehicle_id'])
            ->firstOr(fn () => $this->exceptionValidator(__('trip-import.error.timezone_id-exists')));
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataUserId();
        $this->dataPoints();
        $this->dataCode();
        $this->dataStartUtcAt();
        $this->dataEndUtcAt();
        $this->dataStartAt();
        $this->dataEndAt();
        $this->dataName();
        $this->dataTimezoneId();
    }

    /**
     * @return void
     */
    protected function dataPoints(): void
    {
        try {
            $this->points = GpxService::new($this->data['file']->getPathName())->toArray();
        } catch (Throwable $e) {
            $this->dataPointsError($e);
        }

        if (empty($this->points)) {
            $this->exceptionValidator(__('trip-import.error.points-empty'));
        }
    }

    /**
     * @param \Throwable $e
     *
     * @return void
     */
    protected function dataPointsError(Throwable $e): void
    {
        report($e);

        $this->exceptionValidator(__('trip-import.error.points-empty'));
    }

    /**
     * @return void
     */
    protected function dataCode(): void
    {
        $this->data['code'] = helper()->uuid();
    }

    /**
     * @return void
     */
    protected function dataStartUtcAt(): void
    {
        $this->data['start_utc_at'] = date('Y-m-d H:i:s', $this->points[array_key_first($this->points)]['timestamp']);
    }

    /**
     * @return void
     */
    protected function dataEndUtcAt(): void
    {
        $this->data['end_utc_at'] = date('Y-m-d H:i:s', $this->points[array_key_last($this->points)]['timestamp']);
    }

    /**
     * @return void
     */
    protected function dataStartAt(): void
    {
        $this->data['start_at'] = helper()->dateUtcToTimezone('Y-m-d H:i:s', $this->data['start_utc_at'], $this->timezone->zone);
    }

    /**
     * @return void
     */
    protected function dataEndAt(): void
    {
        $this->data['end_at'] = helper()->dateUtcToTimezone('Y-m-d H:i:s', $this->data['end_utc_at'], $this->timezone->zone);
    }

    /**
     * @return void
     */
    protected function dataName(): void
    {
        $this->data['name'] = $this->data['start_at'].' - '.$this->data['end_at'];
    }

    /**
     * @return void
     */
    protected function dataTimezoneId(): void
    {
        $this->data['timezone_id'] = $this->timezone->id;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkDeviceId();
        $this->checkVehicleId();
    }

    /**
     * @return void
     */
    protected function checkDeviceId(): void
    {
        if ($this->checkDeviceIdExists() === false) {
            $this->exceptionValidator(__('trip-import.error.device_id-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkDeviceIdExists(): bool
    {
        return DeviceModel::query()
            ->selectOnly('id')
            ->byId($this->data['device_id'])
            ->byUserId($this->data['user_id'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function checkVehicleId(): void
    {
        if ($this->checkVehicleIdExists() === false) {
            $this->exceptionValidator(__('trip-import.error.vehicle_id-exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkVehicleIdExists(): bool
    {
        return VehicleModel::query()
            ->selectOnly('id')
            ->byId($this->data['vehicle_id'])
            ->byUserId($this->data['user_id'])
            ->exists();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveRow();
        $this->savePositions();
        $this->saveDistanceTime();
        $this->saveStats();
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row = Model::query()->create([
            'code' => $this->data['code'],
            'name' => $this->data['name'],
            'start_at' => $this->data['start_at'],
            'start_utc_at' => $this->data['start_utc_at'],
            'end_at' => $this->data['end_at'],
            'end_utc_at' => $this->data['end_utc_at'],
            'device_id' => $this->data['device_id'],
            'timezone_id' => $this->data['timezone_id'],
            'user_id' => $this->data['user_id'],
            'vehicle_id' => $this->data['vehicle_id'],
        ])->fresh();
    }

    /**
     * @return void
     */
    protected function savePositions(): void
    {
        foreach (array_chunk($this->points, 1000) as $points) {
            PositionModel::query()->insert(array_map($this->savePositionsData(...), $points));
        }
    }

    /**
     * @param array $point
     *
     * @return array
     */
    protected function savePositionsData(array $point): array
    {
        return [
            'point' => PositionModel::pointFromLatitudeLongitude($point['latitude'], $point['longitude']),
            'speed' => $point['speed'],
            'direction' => $point['direction'],
            'signal' => 1,
            'date_utc_at' => date('Y-m-d H:i:s', $point['timestamp']),
            'date_at' => helper()->timestampToTimezone($point['timestamp'], $this->timezone->zone),
            'device_id' => $this->data['device_id'],
            'timezone_id' => $this->data['timezone_id'],
            'trip_id' => $this->row->id,
            'user_id' => $this->data['user_id'],
            'vehicle_id' => $this->data['vehicle_id'],
        ];
    }

    /**
     * @return void
     */
    protected function saveDistanceTime(): void
    {
        $this->row->updateDistanceTime();
        $this->row->refresh();
    }

    /**
     * @return void
     */
    protected function saveStats(): void
    {
        $this->factory()->action()->updateStats();
    }
}
