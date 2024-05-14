<?php declare(strict_types=1);

namespace App\Domains\Configuration\Controller;

use App\Domains\Configuration\Model\Configuration as Model;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Configuration\Model\Configuration
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\Configuration\Model\Configuration
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->firstOr(fn () => $this->exceptionNotFound(__('configuration.error.not-found')));
    }
}
