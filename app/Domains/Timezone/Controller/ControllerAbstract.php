<?php declare(strict_types=1);

namespace App\Domains\Timezone\Controller;

use App\Domains\Shared\Controller\ControllerWebAbstract;
use App\Domains\Timezone\Model\Timezone as Model;
use App\Exceptions\NotFoundException;

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
        $this->row = Model::query()->byId($id)->firstOr(static function () {
            throw new NotFoundException(__('timezone.error.not-found'));
        });
    }
}
