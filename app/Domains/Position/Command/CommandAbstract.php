<?php declare(strict_types=1);

namespace App\Domains\Position\Command;

use App\Domains\Position\Model\Position as Model;
use App\Domains\CoreApp\Command\CommandAbstract as CommandAbstractSahred;

abstract class CommandAbstract extends CommandAbstractSahred
{
    /**
     * @var \App\Domains\Position\Model\Position
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
