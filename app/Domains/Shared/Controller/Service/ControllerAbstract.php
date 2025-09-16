<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller\Service;

use App\Domains\Core\Controller\Service\ControllerAbstract as ControllerAbstractCore;
use App\Domains\Core\Traits\Factory;

abstract class ControllerAbstract extends ControllerAbstractCore
{
    use Factory;
}
