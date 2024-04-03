<?php declare(strict_types=1);

namespace App\Domains\Trip\ControllerApi;

use App\Domains\CoreApp\Controller\ControllerApiAbstract as CoreControllerApiAbstract;
use App\Domains\Trip\Model\Trip as Model;

abstract class ControllerApiAbstract extends CoreControllerApiAbstract
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
