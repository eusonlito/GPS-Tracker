<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Command;

use App\Domains\Core\Command\CommandAbstract as CommandAbstractCore;

abstract class CommandAbstract extends CommandAbstractCore
{
    /**
     * @return void
     */
    protected function middlewares(): void
    {
        $this->factory('Configuration')->action()->request();
    }
}
