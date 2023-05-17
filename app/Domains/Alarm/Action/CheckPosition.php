<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Alarm\Model\Collection\Alarm as Collection;
use App\Domains\AlarmNotification\Job\Notify as AlarmNotificationNotifyJob;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

class CheckPosition extends ActionAbstract
{
    /**
     * @var \App\Domains\Position\Model\Position
     */
    protected PositionModel $position;

    /**
     * @var \App\Domains\Vehicle\Model\Vehicle
     */
    protected VehicleModel $vehicle;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->position();
        $this->vehicle();
        $this->data();
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function position(): void
    {
        $this->position = PositionModel::query()
            ->withVehicle()
            ->withTrip()
            ->findOrFail($this->data['position_id']);
    }

    /**
     * @return void
     */
    protected function vehicle(): void
    {
        $this->vehicle = $this->position->vehicle;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataLatitude();
        $this->dataLongitude();
        $this->dataSpeed();
    }

    /**
     * @return void
     */
    protected function dataLatitude(): void
    {
        $this->data['latitude'] = $this->position->latitude;
    }

    /**
     * @return void
     */
    protected function dataLongitude(): void
    {
        $this->data['longitude'] = $this->position->longitude;
    }

    /**
     * @return void
     */
    protected function dataSpeed(): void
    {
        $this->data['speed'] = match ($this->position->user->preferences['units']['distance'] ?? 'kilometer') {
            'mile' => $this->position->speed * 0.621371,
            default => $this->position->speed,
        };
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->list() as $row) {
            $this->check($row);
        }
    }

    /**
     * @return \App\Domains\Alarm\Model\Collection\Alarm
     */
    protected function list(): Collection
    {
        return Model::query()
            ->byVehicleIdEnabled($this->vehicle->id)
            ->bySchedule(explode(' ', $this->position->date_at)[1])
            ->check($this->data['latitude'], $this->data['longitude'], $this->data['speed'])
            ->enabled()
            ->get();
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return void
     */
    protected function check(Model $row): void
    {
        if ($this->checkLast($row) === false) {
            return;
        }

        $this->save($row);
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return bool
     */
    protected function checkLast(Model $row): bool
    {
        $notification = AlarmNotificationModel::query()
            ->selectOnly('closed_at')
            ->byAlarmId($row->id)
            ->orderByLast()
            ->first();

        return empty($notification) || $notification->closed_at;
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return void
     */
    protected function save(Model $row): void
    {
        $this->saveJob($this->saveNotification($row));
    }

    /**
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return \App\Domains\AlarmNotification\Model\AlarmNotification
     */
    protected function saveNotification(Model $row): AlarmNotificationModel
    {
        return AlarmNotificationModel::query()->create([
            'name' => $row->name,
            'type' => $row->type,
            'config' => $row->config,

            'telegram' => $row->telegram,

            'point' => AlarmNotificationModel::pointFromLatitudeLongitude($this->position->latitude, $this->position->longitude),

            'date_at' => $this->position->date_at,
            'date_utc_at' => $this->position->date_utc_at,

            'alarm_id' => $row->id,
            'position_id' => $this->position->id,
            'trip_id' => $this->position->trip->id,
            'vehicle_id' => $this->vehicle->id,
        ]);
    }

    /**
     * @param \App\Domains\AlarmNotification\Model\AlarmNotification $notification
     *
     * @return void
     */
    protected function saveJob(AlarmNotificationModel $notification): void
    {
        AlarmNotificationNotifyJob::dispatch($notification->id);
    }
}
