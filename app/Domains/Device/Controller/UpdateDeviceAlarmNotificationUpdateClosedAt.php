<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\RedirectResponse;

class UpdateDeviceAlarmNotificationUpdateClosedAt extends ControllerAbstract
{
    /**
     * @param int $id
     * @param int $device_alarm_notification_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id, int $device_alarm_notification_id): RedirectResponse
    {
        $this->row($id);
        $this->alarmNotification($device_alarm_notification_id);

        $this->actionCall('execute');

        return redirect()->route('device.update.device-alarm-notification', $this->row->id);
    }

    /**
     * @return void
     */
    protected function execute(): void
    {
        $this->factory('DeviceAlarm', $this->alarmNotification->alarm)->action($this->executeData())->notificationUpdateClosedAt();
    }

    /**
     * @return array
     */
    protected function executeData(): array
    {
        return ['device_alarm_notification_id' => $this->alarmNotification->id];
    }
}
