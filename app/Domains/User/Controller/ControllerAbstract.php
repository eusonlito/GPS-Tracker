<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\User\Model\User as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?Model $row;

    /**
     * @return void
     */
    protected function rowAuth(): void
    {
        $this->row = $this->auth;
    }

    /**
     * @param int $id
     *
     * @return void
     */
    protected function row(int $id): void
    {
        $this->row = Model::query()
            ->byId($id)
            ->firstOr(fn () => $this->exceptionNotFound(__('user.error.not-found')));
    }
}
