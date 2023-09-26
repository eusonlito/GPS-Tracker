<?php declare(strict_types=1);

namespace App\Domains\File\Action;

use App\Domains\Core\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\File\Model\File as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\File\Model\File
     */
    protected ?Model $row;
}
