<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use App\Domains\Server\Model\Server as Model;
use App\Domains\Shared\Controller\ControllerWebAbstract;
use App\Exceptions\NotFoundException;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Server\Model\Server
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
            throw new NotFoundException(__('server.error.not-found'));
        });
    }
}
