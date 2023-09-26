<?php declare(strict_types=1);

namespace App\Domains\Country\Action;

use App\Domains\Country\Model\Country as Model;
use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Country\Model\Country
     */
    protected ?Model $row;
}
