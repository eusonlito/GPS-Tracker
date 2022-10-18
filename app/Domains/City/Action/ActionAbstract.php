<?php declare(strict_types=1);

namespace App\Domains\City\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\City\Model\City as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\City\Model\City
     */
    protected ?Model $row;
}
