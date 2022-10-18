<?php declare(strict_types=1);

namespace App\Domains\Position\Command;

use App\Domains\SharedApp\Command\CommandAbstract as CommandAbstractSahred;
use App\Domains\Position\Model\Position as Model;

abstract class CommandAbstract extends CommandAbstractSahred
{
    /**
     * @var \App\Domains\Position\Model\Position
     */
    protected Model $row;
}
