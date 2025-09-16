<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\Server\Model\Server as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Server\Model\Server
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\Server\Model\Server
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->firstOr(fn () => $this->exceptionNotFound(__('server.error.not-found')));
    }
}
