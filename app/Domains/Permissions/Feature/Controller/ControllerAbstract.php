<?php declare(strict_types=1);

namespace App\Domains\Permissions\Feature\Controller;

use App\Domains\Permissions\Feature\Model\Feature as Model;
use App\Domains\CoreApp\Controller\ControllerWebAbstract;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Permissions\Feature\Model\Feature
     */

    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\Permissions\Feature\Model\Feature
     */

    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->first(); // Hoặc find($id)
    }
}
