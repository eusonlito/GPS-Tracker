<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Action;

use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;
use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as DeviceAlarmNotificationModel;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function checkPosition(): void
    {
        $this->actionHandle(CheckPosition::class, $this->validate()->checkPosition());
    }

    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    public function create(): Model
    {
        return $this->actionHandle(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return \App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification
     */
    public function notificationUpdateClosedAt(): DeviceAlarmNotificationModel
    {
        return $this->actionHandle(NotificationUpdateClosedAt::class, $this->validate()->notificationUpdateClosedAt());
    }

    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    public function updateBoolean(): Model
    {
        return $this->actionHandle(UpdateBoolean::class, $this->validate()->updateBoolean());
    }
}
