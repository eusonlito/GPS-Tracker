<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Controller;

use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Maintenance\Model\Maintenance
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\Maintenance\Model\Maintenance
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('maintenance.error.not-found')));
    }
}
