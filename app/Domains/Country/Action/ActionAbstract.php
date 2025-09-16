<?php declare(strict_types=1);

namespace App\Domains\Country\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\Country\Model\Country as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Country\Model\Country
     */
    protected ?Model $row;
}
