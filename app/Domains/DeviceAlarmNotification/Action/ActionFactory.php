<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarmNotification\Action;

use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\DeviceAlarmNotification\Model\DeviceAlarm
     */
    protected ?Model $row;

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
    public function notify(): Model
    {
        return $this->actionHandle(Notify::class);
    }

    /**
     * @return \App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification
     */
    public function updateClosedAt(): Model
    {
        return $this->actionHandle(UpdateClosedAt::class);
    }

    /**
     * @return \App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification
     */
    public function updateSentAt(): Model
    {
        return $this->actionHandle(UpdateSentAt::class);
    }
}
