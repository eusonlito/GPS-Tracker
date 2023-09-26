<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\CoreApp\Action\UpdateBoolean as UpdateBooleanCoreApp;

class UpdateBoolean extends UpdateBooleanCoreApp
{
    /**
     * @var \App\Domains\Alarm\Model\Alarm
     */
    protected Model $row;
}
