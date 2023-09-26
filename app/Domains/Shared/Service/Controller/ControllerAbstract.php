<?php declare(strict_types=1);

namespace App\Domains\Shared\Service\Controller;

use App\Domains\Core\Service\Controller\ControllerAbstract as ControllerAbstractCore;

abstract class ControllerAbstract extends ControllerAbstractCore
{
    /**
     * @var array
     */
    protected array $cache = [];
}
