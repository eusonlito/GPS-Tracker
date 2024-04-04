<?php declare(strict_types=1);

namespace App\Domains\Refuel\Test\Controller;

use App\Domains\CoreApp\Test\Controller\ControllerAbstract as CoreAppControllerAbstract;
use App\Domains\Refuel\Test\Traits\Controller as ControllerTrait;

abstract class ControllerAbstract extends CoreAppControllerAbstract
{
    use ControllerTrait;
}
