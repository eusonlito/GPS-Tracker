<?php declare(strict_types=1);

namespace App\Domains\Device\ControllerApi;

use App\Domains\CoreApp\Controller\ControllerApiAbstract as CoreControllerApiAbstract;
use App\Domains\Device\Model\Device as Model;

abstract class ControllerApiAbstract extends CoreControllerApiAbstract
{
    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\Device\Model\Device
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('device.error.not-found')));
    }
}
