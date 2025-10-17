<?php declare(strict_types=1);

namespace App\Domains\Position\Action;

use App\Domains\Alarm\Job\CheckPosition as AlarmCheckPositionJob;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Position\Job\UpdateCity as UpdateCityJob;
use App\Domains\Position\Model\Position as Model;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;
use App\Services\Filesystem\Directory;

class Create extends ActionAbstract
{
    /**
     * @var string
     */
    protected string $uuid;

    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?DeviceModel $device;

    /**
     * @var \App\Domains\Vehicle\Model\Vehicle
     */
    protected VehicleModel $vehicle;

    /**
     * @var \App\Domains\Timezone\Model\Timezone
     */
    protected TimezoneModel $timezone;

    /**
     * @var \App\Domains\Trip\Model\Trip
     */
    protected TripModel $trip;

    /**
     * @var ?\App\Domains\Position\Model\Position
     */
    protected ?Model $previous = null;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->uuid();
        $this->device();

        if ($this->isValidDevice() === false) {
            return;
        }

        $this->deviceConnected();
        $this->vehicle();
        $this->timezone();
        $this->data();
        $this->previous();

        if ($this->isValid() === false) {
            return;
        }

        $this->trip();
        $this->save();
        $this->job();
    }

    /**
     * @return void
     */
    protected function uuid(): void
    {
        $this->uuid = uniqid();
    }

    /**
     * @return void
     */
    protected function device(): void
    {
        $this->device = DeviceModel::query()
            ->bySerial($this->data['serial'])
            ->enabled()
            ->first();
    }

    /**
     * @return bool
     */
    protected function isValidDevice(): bool
    {
        return boolval($this->device?->vehicle?->enabled);
    }

    /**
     * @return void
     */
    protected function deviceConnected(): void
    {
        $this->device->connected_at = date('Y-m-d H:i:s');
        $this->device->save();
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
        $this->timezone = $this->timezoneByLatitudeLongitude()
            ?: $this->timezoneByZone()
            ?: $this->vehicle->timezone;
    }

    /**
     * @return ?\App\Domains\Timezone\Model\Timezone
     */
    protected function timezoneByLatitudeLongitude(): ?TimezoneModel
    {
        if ($this->vehicle->timezone_auto === false) {
            return null;
        }

        return TimezoneModel::query()
            ->byLatitudeLongitude($this->data['latitude'], $this->data['longitude'])
            ->first();
    }

    /**
     * @return ?\App\Domains\Timezone\Model\Timezone
     */
    protected function timezoneByZone(): ?TimezoneModel
    {
        if ($this->vehicle->timezone_auto === false) {
            return null;
        }

        return TimezoneModel::query()
            ->byZone($this->data['timezone'])
            ->first();
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataPoint();
        $this->dataTimezoneId();
        $this->dataDateAt();
        $this->dataSpeed();
        $this->dataDebug();
    }

    /**
     * @return void
     */
    protected function dataPoint(): void
    {
        $this->data['point'] = Model::pointFromLatitudeLongitude($this->data['latitude'], $this->data['longitude']);
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
    protected function dataDateAt(): void
    {
        $this->data['date_at'] = helper()->dateUtcToTimezone('Y-m-d H:i:s', $this->data['date_utc_at'], $this->timezone->zone);
    }

    /**
     * @return void
     */
    protected function dataSpeed(): void
    {
        if ($this->data['speed'] > 999) {
            $this->data['speed'] = 0;
        }
    }

    /**
     * @return void
     */
    protected function dataDebug(): void
    {
        $this->logDebug('DATA', $this->data);
    }

    /**
     * @return void
     */
    protected function previous(): void
    {
        $this->previous = Model::query()
            ->byDeviceId($this->device->id)
            ->byDateUtcAtBeforeEqualNear($this->data['date_utc_at'])
            ->first();
    }

    /**
     * @return bool
     */
    protected function isValid(): bool
    {
        if ($this->isValidSignal() === false) {
            return $this->logDebug('isValidSignal', 'false', false);
        }

        if ($this->isValidNotExists() === false) {
            return $this->logDebug('isValidNotExists', 'false', false);
        }

        if ($this->isValidPreviousDifferent() === false) {
            return $this->logDebug('isValidPreviousDifferent', 'false', false);
        }

        if ($this->isValidPreviousFilterDistance() === false) {
            return $this->logDebug('isValidPreviousFilterDistance', 'false', false);
        }

        if ($this->isValidPreviousFilterTime() === false) {
            return $this->logDebug('isValidPreviousFilterTime', 'false', false);
        }

        return true;
    }

    /**
     * @return bool
     */
    protected function isValidSignal(): bool
    {
        return $this->data['signal']
            || (app('configuration')->bool('position_filter_signal') === false);
    }

    /**
     * @return bool
     */
    protected function isValidNotExists(): bool
    {
        return Model::query()
            ->byDeviceId($this->device->id)
            ->byDateUtcAt($this->data['date_utc_at'])
            ->count() === 0;
    }

    /**
     * @return bool
     */
    protected function isValidPreviousDifferent(): bool
    {
        if (empty($this->previous)) {
            return true;
        }

        $this->logDebug('PREVIOUS', $this->previous->toArray());

        return ((string)$this->previous->speed !== (string)$this->data['speed'])
            || ((string)$this->previous->latitude !== (string)$this->data['latitude'])
            || ((string)$this->previous->longitude !== (string)$this->data['longitude'])
            || ((string)$this->previous->direction !== (string)$this->data['direction']);
    }

    /**
     * @return bool
     */
    protected function isValidPreviousFilterDistance(): bool
    {
        if (empty($this->previous)) {
            return true;
        }

        $distance = $this->device->config('position_filter_distance');

        if ($distance === 0) {
            return true;
        }

        if ($this->isValidPreviousFilterDistanceMovement()) {
            return true;
        }

        $meters = helper()->coordinatesDistance(
            $this->previous->latitude,
            $this->previous->longitude,
            $this->data['latitude'],
            $this->data['longitude'],
        );

        return $meters > $distance;
    }

    /**
     * @return bool
     */
    protected function isValidPreviousFilterDistanceMovement(): bool
    {
        return boolval($this->previous->speed) !== boolval($this->data['speed']);
    }

    /**
     * @return bool
     */
    protected function isValidPreviousFilterTime(): bool
    {
        if (empty($this->previous)) {
            return true;
        }

        $time = $this->device->config('position_filter_time');

        if ($time === 0) {
            return true;
        }

        return (strtotime($this->data['date_utc_at']) - strtotime($this->previous->date_utc_at)) > $time;
    }

    /**
     * @return void
     */
    protected function trip(): void
    {
        $this->trip = $this->factory('Trip')->action($this->tripData())->lastOrNew();
    }

    /**
     * @return array
     */
    protected function tripData(): array
    {
        return [
            'date_at' => $this->data['date_at'],
            'date_utc_at' => $this->data['date_utc_at'],
            'speed' => $this->data['speed'],
            'device_id' => $this->device->id,
            'timezone_id' => $this->timezone->id,
        ];
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveRow();
        $this->saveTrip();
        $this->saveDebug();
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row = Model::query()->create([
            'point' => $this->data['point'],
            'speed' => $this->data['speed'],
            'direction' => $this->data['direction'],
            'signal' => $this->data['signal'],
            'date_at' => $this->data['date_at'],
            'date_utc_at' => $this->data['date_utc_at'],

            'device_id' => $this->device->id,
            'timezone_id' => $this->timezone->id,
            'trip_id' => $this->trip->id,
            'user_id' => $this->device->user_id,
            'vehicle_id' => $this->vehicle->id,
        ]);
    }

    /**
     * @return void
     */
    protected function saveTrip(): void
    {
        $this->factory('Trip', $this->trip)->action()->updateNameDistanceTime();
    }

    /**
     * @return void
     */
    protected function saveDebug(): void
    {
        if ($this->data['debug']) {
            $this->logDebug('ROW', $this->row->fresh()->toArray());
        }
    }

    /**
     * @return void
     */
    protected function job(): void
    {
        $this->jobAlarm();
        $this->jobCity();
    }

    /**
     * @return void
     */
    protected function jobAlarm(): void
    {
        AlarmCheckPositionJob::dispatch($this->row->id);
    }

    /**
     * @return void
     */
    protected function jobCity(): void
    {
        UpdateCityJob::dispatch($this->row->id);
    }

    /**
     * @param string $title
     * @param mixed $message
     * @param mixed $return = null
     *
     * @return mixed
     */
    protected function logDebug(string $title, mixed $message, mixed $return = null): mixed
    {
        if (empty($this->data['debug'])) {
            return $return;
        }

        $file = $this->logDebugFile();

        Directory::create($file, true);

        file_put_contents($file, $this->logDebugContent($title, $message), LOCK_EX | FILE_APPEND);

        return $return;
    }

    /**
     * @return string
     */
    protected function logDebugFile(): string
    {
        return base_path('storage/logs/position/'.date('Y/m/Y-m-d').'.log');
    }

    /**
     * @param string $title
     * @param mixed $message
     *
     * @return string
     */
    protected function logDebugContent(string $title, mixed $message): string
    {
        if ($message && (is_scalar($message) === false)) {
            $message = json_encode($message, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return '['.$this->logDebugContentTimestamp().'] ['.$this->uuid.'] ['.$title.'] '.$message."\n";
    }

    /**
     * @return string
     */
    protected function logDebugContentTimestamp(): string
    {
        return date_create()->format('Y-m-d H:i:s.v P');
    }
}
