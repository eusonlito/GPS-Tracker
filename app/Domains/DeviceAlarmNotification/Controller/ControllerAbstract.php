<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarmNotification\Controller;

use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as Model;
use App\Domains\Shared\Controller\ControllerWebAbstract;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\DeviceAlarmNotification\Model\DeviceAlarm
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return void
     */
    protected function row(int $id): void
    {
        $this->row = Model::query()->byId($id)->byUserId($this->auth->id)->firstOr(static function () {
            throw new NotFoundException(__('device.error.not-found'));
        });
    }
}
