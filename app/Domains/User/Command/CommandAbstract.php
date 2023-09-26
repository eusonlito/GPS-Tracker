<?php declare(strict_types=1);

namespace App\Domains\User\Command;

use App\Domains\Core\Command\CommandAbstract as CommandAbstractSahred;
use App\Domains\User\Model\User as Model;

abstract class CommandAbstract extends CommandAbstractSahred
{
    /**
     * @var \App\Domains\User\Model\User
     */
    protected Model $row;

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::query()->findOrFail($this->checkOption('id'));
        $this->actingAs($this->row);
    }
}
