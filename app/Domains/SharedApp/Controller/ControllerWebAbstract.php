<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Controller;

use App\Domains\Shared\Controller\ControllerWebAbstract as SharedControllerWebAbstract;

abstract class ControllerWebAbstract extends SharedControllerWebAbstract
{
    /**
     * @return void
     */
    protected function initCustom(): void
    {
        view()->share([
            'MEMORY_USAGE' => helper()->sizeHuman(memory_get_usage(false)),
            'EXECUTION_TIME' => sprintf('%.3f', microtime(true) - LARAVEL_START, 3),
        ]);
    }
}
