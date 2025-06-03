<?php declare(strict_types=1);

namespace App\Domains\Shared\Service\Controller;

use App\Domains\Core\Service\Controller\ControllerAbstract as ControllerAbstractCore;
use App\Domains\Core\Traits\Factory;

abstract class ControllerAbstract extends ControllerAbstractCore
{
    use Factory;
}
