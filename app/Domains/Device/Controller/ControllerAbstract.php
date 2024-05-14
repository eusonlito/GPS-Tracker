<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\Device\Model\Device as Model;
use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?Model $row;

    /**
     * @var ?\App\Domains\Alarm\Model\Alarm
     */
    protected ?AlarmModel $alarm;

    /**
     * @var ?\App\Domains\AlarmNotification\Model\AlarmNotification
     */
    protected ?AlarmNotificationModel $alarmNotification;

    /**
     * @var ?\App\Domains\DeviceMessage\Model\DeviceMessage
     */
    protected ?DeviceMessageModel $message;

    /**
     * @param int $id
     *
     * @return \App\Domains\Device\Model\Device
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('device.error.not-found')));
    }

    /**
     * @param int $alarm_id
     *
     * @return \App\Domains\Alarm\Model\Alarm
     */
    protected function alarm(int $alarm_id): AlarmModel
    {
        return $this->alarm = AlarmModel::query()
            ->byId($alarm_id)
            ->byDeviceId($this->row->id)
            ->firstOr(fn () => $this->exceptionNotFound(__('device.error.not-found')));
    }

    /**
     * @param int $alarm_notification_id
     *
     * @return \App\Domains\AlarmNotification\Model\AlarmNotification
     */
    protected function alarmNotification(int $alarm_notification_id): AlarmNotificationModel
    {
        return $this->alarmNotification = AlarmNotificationModel::query()
            ->byId($alarm_notification_id)
            ->byDeviceId($this->row->id)
            ->firstOr(fn () => $this->exceptionNotFound(__('device.error.not-found')));
    }

    /**
     * @param int $device_message_id
     *
     * @return \App\Domains\DeviceMessage\Model\DeviceMessage
     */
    protected function message(int $device_message_id): DeviceMessageModel
    {
        return $this->message = DeviceMessageModel::query()
            ->byId($device_message_id)
            ->byDeviceId($this->row->id)
            ->firstOr(fn () => $this->exceptionNotFound(__('device.error.not-found')));
    }
}
