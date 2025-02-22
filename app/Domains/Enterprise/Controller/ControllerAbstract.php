<?php

namespace App\Domains\Enterprise\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Models\Enterprise as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    protected ?Model $row;

    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('enterprise.error.not-found')));
    }
}
