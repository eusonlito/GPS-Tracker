<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Service\Controller;

use App\Domains\Shared\Service\Controller\ControllerAbstract as ControllerAbstractShared;

abstract class ControllerAbstract extends ControllerAbstractShared
{
    /**
     * @var array
     */
    protected array $cache = [];
}
