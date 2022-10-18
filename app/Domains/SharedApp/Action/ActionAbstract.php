<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Action;

use App\Domains\Shared\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\SharedApp\Action\Traits\LogRow as LogRowTrait;

abstract class ActionAbstract extends ActionAbstractShared
{
    use LogRowTrait;
}
