<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Controller;

use App\Domains\AlarmNotification\Model\AlarmNotification as Model;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\AlarmNotification\Model\AlarmNotification
     */
    protected ?Model $row;

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
            ->firstOr(fn () => $this->exceptionNotFound(__('alarm-notification.error.not-found')));
    }
}
