<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Command;

use App\Domains\Shared\Command\CommandAbstract as CommandAbstractShared;

abstract class CommandAbstract extends CommandAbstractShared
{
    /**
     * @return void
     */
    protected function middlewares(): void
    {
        $this->factory('Configuration')->action()->request();
    }
}
