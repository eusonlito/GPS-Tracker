<?php declare(strict_types=1);

namespace App\Domains\City\Action;

use App\Domains\City\Model\City as Model;
use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\City\Model\City
     */
    protected ?Model $row;
}
