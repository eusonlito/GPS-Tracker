<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Alarm\Model\Alarm
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return void
     */
    protected function row(int $id): void
    {
        $this->row = Model::query()->byId($id)->byUserOrAdmin($this->auth)->firstOr(static function () {
            throw new NotFoundException(__('alarm.error.not-found'));
        });
    }
}
