<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\MaintenanceItem\Model\MaintenanceItem
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\MaintenanceItem\Model\MaintenanceItem
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('maintenance-item.error.not-found')));
    }
}
