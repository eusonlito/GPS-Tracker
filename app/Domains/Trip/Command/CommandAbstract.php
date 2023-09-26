<?php declare(strict_types=1);

namespace App\Domains\Trip\Command;

use App\Domains\CoreApp\Command\CommandAbstract as CommandAbstractSahred;
use App\Domains\Trip\Model\Trip as Model;

abstract class CommandAbstract extends CommandAbstractSahred
{
    /**
     * @var \App\Domains\Trip\Model\Trip
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
