<?php declare(strict_types=1);

namespace App\Domains\UserSession\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\UserSession\Model\UserSession as Model;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\UserSession\Model\UserSession
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\UserSession\Model\UserSession
     */
    public function create(): Model
    {
        return $this->actionHandle(Create::class, $this->validate()->create());
    }
}
