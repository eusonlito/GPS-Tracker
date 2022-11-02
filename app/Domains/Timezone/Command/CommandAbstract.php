<?php declare(strict_types=1);

namespace App\Domains\Timezone\Command;

use App\Domains\SharedApp\Command\CommandAbstract as CommandAbstractSahred;
use App\Domains\Timezone\Model\Timezone as Model;

abstract class CommandAbstract extends CommandAbstractSahred
{
    /**
     * @var \App\Domains\Timezone\Model\Timezone
     */
    protected Model $row;
}
