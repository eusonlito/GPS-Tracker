<?php declare(strict_types=1);

namespace App\Domains\Shared\Service\Controller;

use App\Domains\Core\Service\Controller\ControllerAbstract as ControllerAbstractCore;

abstract class ControllerAbstract extends ControllerAbstractCore
{
    /**
     * @return string
     */
    protected function sharedUrl(): string
    {
        return route('shared.index', app('configuration')->string('shared_slug'));
    }
}
