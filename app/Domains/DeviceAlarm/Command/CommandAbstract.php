<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Command;

use App\Domains\SharedApp\Command\CommandAbstract as CommandAbstractSahred;
use App\Domains\DeviceAlarm\Model\DeviceAlarm as Model;

abstract class CommandAbstract extends CommandAbstractSahred
{
    /**
     * @var \App\Domains\DeviceAlarm\Model\DeviceAlarm
     */
    protected Model $row;

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::findOrFail($this->checkOption('id'));
    }
}
