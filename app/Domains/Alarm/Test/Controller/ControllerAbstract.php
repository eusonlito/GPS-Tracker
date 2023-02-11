<?php declare(strict_types=1);

namespace App\Domains\Alarm\Test\Controller;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\SharedApp\Test\Feature\FeatureAbstract;

abstract class ControllerAbstract extends FeatureAbstract
{
    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Model::class;
    }
}
