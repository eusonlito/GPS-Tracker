<?php declare(strict_types=1);

namespace App\Domains\UserSession\Action;

use App\Domains\Shared\Action\ActionFactoryAbstract;
use App\Domains\UserSession\Model\UserSession as Model;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\UserSession\Model\UserSession
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function fail(): void
    {
        $this->actionHandle(Fail::class, $this->validate()->fail());
    }

    /**
     * @return void
     */
    public function success(): void
    {
        $this->actionHandle(Success::class, $this->validate()->success(), ...func_get_args());
    }
}
