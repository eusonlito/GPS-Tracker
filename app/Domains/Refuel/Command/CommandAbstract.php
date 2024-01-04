<?php declare(strict_types=1);

namespace App\Domains\Refuel\Command;

use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\CoreApp\Command\CommandAbstract as CommandAbstractSahred;

abstract class CommandAbstract extends CommandAbstractSahred
{
    /**
     * @var \App\Domains\Refuel\Model\Refuel
     */
    protected Model $row;

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::query()->findOrFail($this->checkOption('id'));
    }
}
