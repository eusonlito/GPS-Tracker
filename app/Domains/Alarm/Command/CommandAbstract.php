<?php declare(strict_types=1);

namespace App\Domains\Alarm\Command;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\CoreApp\Command\CommandAbstract as CommandAbstractSahred;

abstract class CommandAbstract extends CommandAbstractSahred
{
    /**
     * @var \App\Domains\Alarm\Model\Alarm
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
