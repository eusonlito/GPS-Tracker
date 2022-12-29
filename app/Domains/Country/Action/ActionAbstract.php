<?php declare(strict_types=1);

namespace App\Domains\Country\Action;

use App\Domains\Country\Model\Country as Model;
use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\Country\Model\Country
     */
    protected ?Model $row;
}
