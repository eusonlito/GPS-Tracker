<?php declare(strict_types=1);

namespace App\Domains\Timezone\Action;

use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;
use App\Domains\Timezone\Model\Timezone as Model;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var ?\App\Domains\Timezone\Model\Timezone
     */
    protected ?Model $row;
}
