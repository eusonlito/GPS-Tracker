<?php declare(strict_types=1);

namespace App\Domains\IpLock\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\IpLock\Model\IpLock as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\IpLock\Model\IpLock
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\IpLock\Model\IpLock
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->firstOr(fn () => $this->exceptionNotFound(__('ip-lock.error.not-found')));
    }
}
