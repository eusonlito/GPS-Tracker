<?php declare(strict_types=1);

namespace App\Domains\File\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\File\Model\File as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\File\Model\File
     */
    protected ?Model $row;

    /**
     * @param int $id
     *
     * @return \App\Domains\File\Model\File
     */
    protected function row(int $id): Model
    {
        return $this->row = Model::query()
            ->byId($id)
            ->byUserOrManager($this->auth)
            ->firstOr(fn () => $this->exceptionNotFound(__('file.error.not-found')));
    }
}
