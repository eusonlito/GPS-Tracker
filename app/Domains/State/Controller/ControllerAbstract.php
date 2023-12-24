<?php declare(strict_types=1);

namespace App\Domains\State\Controller;

use App\Domains\State\Model\State as Model;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\State\Model\State
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
            ->firstOr(fn () => $this->exceptionNotFound(__('state.error.not-found')));
    }
}
