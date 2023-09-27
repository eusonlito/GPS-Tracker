<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Controller;

use App\Domains\Core\Controller\ControllerWebAbstract as CoreControllerWebAbstract;

abstract class ControllerWebAbstract extends CoreControllerWebAbstract
{
    /**
     * @psalm-suppress UndefinedConstant
     *
     * @return void
     */
    protected function initCustom(): void
    {
        view()->share([
            'MEMORY_USAGE' => helper()->sizeHuman(memory_get_peak_usage(false)),
            'EXECUTION_TIME' => sprintf('%.3f', microtime(true) - LARAVEL_START),
        ]);
    }
}
