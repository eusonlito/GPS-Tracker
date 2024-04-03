<?php declare(strict_types=1);

namespace App\Domains\User\ControllerApi;

use App\Domains\CoreApp\Controller\ControllerApiAbstract as CoreControllerApiAbstract;
use App\Domains\User\Model\User as Model;

abstract class ControllerApiAbstract extends CoreControllerApiAbstract
{
    /**
     * @var ?\App\Domains\User\Model\User
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
            ->firstOr(fn () => $this->exceptionNotFound(__('user.error.not-found')));
    }
}
