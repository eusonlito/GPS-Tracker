<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Action;

use Illuminate\Support\Collection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;
use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as DeviceAlarmNotificationModel;
use App\Domains\DeviceAlarmNotification\Job\Notify as DeviceAlarmNotificationNotifyJob;
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
     * @param \App\Domains\DeviceAlarm\Model\DeviceAlarm $row
     *
     * @return void
     */
    protected function check(Model $row): void
    {
        if ($row->typeFormat()->checkPosition($this->position)) {
            $this->save($row);
        }
    }

    /**
     * @param \App\Domains\DeviceAlarm\Model\DeviceAlarm $row
     *
     * @return void
     */
    protected function save(Model $row): void
    {
        $this->saveRow($row);
        $this->saveJob($this->saveNotification($row));
    }

    /**
     * @param \App\Domains\DeviceAlarm\Model\DeviceAlarm $row
     *
     * @return void
     */
    protected function saveRow(Model $row): void
    {
        $row->enabled = false;
        $row->save();
    }

    /**
     * @param \App\Domains\DeviceAlarm\Model\DeviceAlarm $row
     *
     * @return \App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification
     */
    protected function saveNotification(Model $row): DeviceAlarmNotificationModel
    {
        return DeviceAlarmNotificationModel::create([
            'name' => $row->name,
            'type' => $row->type,
            'config' => $row->config,

            'telegram' => $row->telegram,

            'device_id' => $this->device->id,
            'device_alarm_id' => $row->id,
            'position_id' => $this->position->id,
            'trip_id' => $this->position->trip->id,
        ]);
    }

    /**
     * @param \App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification $notification
     *
     * @return void
     */
    protected function saveJob(DeviceAlarmNotificationModel $notification): void
    {
        DeviceAlarmNotificationNotifyJob::dispatch($notification->id);
    }
}
