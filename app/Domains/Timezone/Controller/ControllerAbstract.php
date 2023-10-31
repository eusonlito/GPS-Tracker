<?php declare(strict_types=1);

namespace App\Domains\Timezone\Controller;

use App\Domains\CoreApp\Controller\ControllerWebAbstract;
use App\Domains\Timezone\Model\Timezone as Model;

abstract class ControllerAbstract extends ControllerWebAbstract
{
    /**
     * @var ?\App\Domains\Timezone\Model\Timezone
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
            ->firstOr(fn () => $this->exceptionNotFound(__('timezone.error.not-found')));
    }
}
