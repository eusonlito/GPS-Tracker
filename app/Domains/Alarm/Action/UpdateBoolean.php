<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\SharedApp\Action\UpdateBoolean as UpdateBooleanSharedApp;

class UpdateBoolean extends UpdateBooleanSharedApp
{
    /**
     * @var \App\Domains\Alarm\Model\Alarm
     */
    protected Model $row;
}
