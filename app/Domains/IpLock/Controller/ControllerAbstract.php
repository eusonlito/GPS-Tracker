<?php declare(strict_types=1);

namespace App\Domains\IpLock\Controller;

use App\Domains\Shared\Controller\ControllerWebAbstract;
use App\Domains\IpLock\Model\IpLock as Model;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\IpLock\Model\IpLock
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return void
     */
    protected function row(int $id): void
    {
        $this->row = Model::query()->byId($id)->firstOr(static function () {
            throw new NotFoundException(__('ip-lock.error.not-found'));
        });
    }
}
