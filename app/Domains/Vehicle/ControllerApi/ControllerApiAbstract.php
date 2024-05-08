<?php declare(strict_types=1);

namespace App\Domains\Vehicle\ControllerApi;

use App\Domains\CoreApp\Controller\ControllerApiAbstract as CoreControllerApiAbstract;
use App\Domains\Vehicle\Model\Vehicle as Model;

abstract class ControllerApiAbstract extends CoreControllerApiAbstract
{
    /**
     * @var ?\App\Domains\Vehicle\Model\Vehicle
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\Vehicle\Model\Vehicle
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('vehicle.error.not-found')));
    }
}
