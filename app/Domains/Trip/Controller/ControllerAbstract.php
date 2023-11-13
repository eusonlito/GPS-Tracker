<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\Trip\Model\Trip as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Trip\Model\Trip
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
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('trip.error.not-found')));
    }
}
