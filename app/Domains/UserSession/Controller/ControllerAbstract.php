<?php declare(strict_types=1);

namespace App\Domains\UserSession\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\UserSession\Model\UserSession as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\UserSession\Model\UserSession
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
            ->firstOr(fn () => $this->exceptionNotFound(__('user-sessoin.error.not-found')));
    }
}
