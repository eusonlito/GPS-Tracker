<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use App\Domains\Device\Model\Device as Model;
use App\Domains\Shared\Controller\ControllerWebAbstract;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?Model $row;

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
}
