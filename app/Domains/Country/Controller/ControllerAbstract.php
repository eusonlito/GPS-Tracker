<?php declare(strict_types=1);

namespace App\Domains\Country\Controller;

use App\Domains\Country\Model\Country as Model;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Country\Model\Country
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
            ->firstOr(fn () => $this->exceptionNotFound(__('country.error.not-found')));
    }
}
