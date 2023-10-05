<?php declare(strict_types=1);

namespace App\Domains\UserFail\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\UserFail\Model\UserFail as Model;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\UserFail\Model\UserFail
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\UserFail\Model\UserFail
     */
    public function create(): Model
    {
        return $this->actionHandle(Create::class, $this->validate()->create());
    }
}
