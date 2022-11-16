<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Action;

use App\Domains\DeviceAlarm\Model\DeviceAlarmNotification as DeviceAlarmNotificationModel;

class NotificationUpdateClosedAt extends ActionAbstract
{
    /**
     * @var \App\Domains\DeviceAlarm\Model\DeviceAlarmNotification
     */
    protected DeviceAlarmNotificationModel $notification;

    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarmNotification
     */
    public function handle(): DeviceAlarmNotificationModel
    {
        $this->notification();
        $this->save();

        return $this->notification;
    }

    /**
     * @return void
     */
    protected function notification(): void
    {
        $this->notification = DeviceAlarmNotificationModel::query()
            ->byDeviceAlarmId($this->row->id)
            ->findOrFail($this->data['device_alarm_notification_id']);
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        if ($this->notification->closed_at) {
            return;
        }

        $this->notification->closed_at = date('Y-m-d H:i:s');
        $this->notification->save();
    }
}
