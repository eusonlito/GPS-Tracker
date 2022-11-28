<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use Illuminate\Support\Collection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\AlarmNotification\Job\Notify as AlarmNotificationNotifyJob;
use App\Domains\Position\Model\Position as PositionModel;

class CheckPosition extends ActionAbstract
{
    /**
     * @var \App\Domains\Position\Model\Position
     */
    protected PositionModel $position;

    /**
     * @var \App\Domains\Device\Model\Device
     */
    protected DeviceModel $device;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->position();
        $this->device();
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function position(): void
    {
        $this->position = PositionModel::query()
            ->withDevice()
            ->withTrip()
            ->findOrFail($this->data['position_id']);
    }

    /**
     * @return void
     */
    protected function device(): void
    {
        $this->device = $this->position->device;
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
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        return Model::query()
            ->byDeviceIdEnabled($this->device->id)
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

        if ($this->checkFormat($row) === false) {
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
     * @return bool
     */
    protected function checkFormat(Model $row): bool
    {
        return $row->typeFormat()->checkPosition($this->position);
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

            'device_id' => $this->device->id,
            'alarm_id' => $row->id,
            'position_id' => $this->position->id,
            'trip_id' => $this->position->trip->id,
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
