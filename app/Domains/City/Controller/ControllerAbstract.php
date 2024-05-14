<?php declare(strict_types=1);

namespace App\Domains\City\Controller;

use App\Domains\City\Model\City as Model;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\City\Model\City
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\City\Model\City
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->firstOr(fn () => $this->exceptionNotFound(__('city.error.not-found')));
    }
}
