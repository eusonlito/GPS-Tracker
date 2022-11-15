<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use App\Domains\Device\Model\Device as Model;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as DeviceAlarmModel;
use App\Domains\DeviceAlarm\Model\DeviceAlarmNotification as DeviceAlarmNotificationModel;
use App\Domains\DeviceMessage\Model\DeviceMessage as DeviceMessageModel;
use App\Domains\Shared\Controller\ControllerWebAbstract;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?Model $row;

    /**
     * @var ?\App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    protected ?DeviceAlarmModel $alarm;

    /**
     * @var ?\App\Domains\DeviceAlarm\Model\DeviceAlarmNotification
     */
    protected ?DeviceAlarmNotificationModel $alarmNotification;

    /**
     * @var ?\App\Domains\DeviceMessage\Model\DeviceMessage
     */
    protected ?DeviceMessageModel $message;

    /**
     * @param int $id
     *
     * @return void
     */
    protected function row(int $id): void
    {
        $this->row = Model::byId($id)->byUserId($this->auth->id)->firstOr(static function () {
            throw new NotFoundException(__('device.error.not-found'));
        });
    }

    /**
     * @param int $device_alarm_id
     *
     * @return void
     */
    protected function alarm(int $device_alarm_id): void
    {
        $this->alarm = DeviceAlarmModel::byId($device_alarm_id)
            ->byDeviceId($this->row->id)
            ->firstOr(static function () {
                throw new NotFoundException(__('device.error.not-found'));
            });
    }

    /**
     * @param int $device_alarm_notification_id
     *
     * @return void
     */
    protected function alarmNotification(int $device_alarm_notification_id): void
    {
        $this->alarmNotification = DeviceAlarmNotificationModel::byId($device_alarm_notification_id)
            ->byDeviceId($this->row->id)
            ->firstOr(static function () {
                throw new NotFoundException(__('device.error.not-found'));
            });
    }

    /**
     * @param int $device_message_id
     *
     * @return void
     */
    protected function message(int $device_message_id): void
    {
        $this->message = DeviceMessageModel::byId($device_message_id)
            ->byDeviceId($this->row->id)
            ->firstOr(static function () {
                throw new NotFoundException(__('device.error.not-found'));
            });
    }
}
