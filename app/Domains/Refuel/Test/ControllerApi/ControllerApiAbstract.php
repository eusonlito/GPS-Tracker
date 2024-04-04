<?php declare(strict_types=1);

namespace App\Domains\Refuel\Test\ControllerApi;

use App\Domains\CoreApp\Test\ControllerApi\ControllerApiAbstract as CoreAppControllerApiAbstract;
use App\Domains\Refuel\Test\Traits\Controller as ControllerTrait;

abstract class ControllerApiAbstract extends CoreAppControllerApiAbstract
{
    use ControllerTrait;
}
