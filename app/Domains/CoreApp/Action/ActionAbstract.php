<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Action;

use App\Domains\Core\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\CoreApp\Action\Traits\LogRow as LogRowTrait;

abstract class ActionAbstract extends ActionAbstractCore
{
    use LogRowTrait;
}
