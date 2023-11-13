<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Controller;

use App\Domains\Alarm\Model\Alarm as AlarmModel;
use App\Domains\AlarmNotification\Model\AlarmNotification as AlarmNotificationModel;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\Vehicle\Model\Vehicle as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Vehicle\Model\Vehicle
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
     * @param int $id
     *
     * @return void
     */
    protected function row(int $id): void
    {
        $this->row = Model::query()
            ->byId($id)
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('vehicle.error.not-found')));
    }

    /**
     * @param int $alarm_id
     *
     * @return void
     */
    protected function alarm(int $alarm_id): void
    {
        $this->alarm = AlarmModel::query()
            ->byId($alarm_id)
            ->byVehicleId($this->row->id)
            ->firstOr(fn () => $this->exceptionNotFound(__('vehicle.error.not-found')));
    }

    /**
     * @param int $alarm_notification_id
     *
     * @return void
     */
    protected function alarmNotification(int $alarm_notification_id): void
    {
        $this->alarmNotification = AlarmNotificationModel::query()
            ->byId($alarm_notification_id)
            ->byVehicleId($this->row->id)
            ->firstOr(fn () => $this->exceptionNotFound(__('vehicle.error.not-found')));
    }
}
