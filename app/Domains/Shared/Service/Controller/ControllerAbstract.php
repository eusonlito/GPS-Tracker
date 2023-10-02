<?php declare(strict_types=1);

namespace App\Domains\Shared\Service\Controller;

use App\Domains\Core\Service\Controller\ControllerAbstract as ControllerAbstractCore;
use App\Domains\Configuration\Service\Getter\Getter as ConfigurationGetter;

abstract class ControllerAbstract extends ControllerAbstractCore
{
    /**
     * @return string
     */
    protected function sharedUrl(): string
    {
        return route('shared.index', $this->configuration()->string('shared_slug'));
    }

    /**
     * @return string
     */
    protected function sharedUrlMap(): string
    {
        return route('shared.map', $this->configuration()->string('shared_slug'));
    }

    /**
     * @return \App\Domains\Configuration\Service\Getter\Getter
     */
    protected function configuration(): ConfigurationGetter
    {
        static $cache;

        return $cache ??= app('configuration');
    }
}
