<?php declare(strict_types=1);

namespace App\Domains\Language\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\Language\Model\Language as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Language\Model\Language
     */
    protected ?Model $row;
}
