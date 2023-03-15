<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\IpLock\Model\IpLock as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\IpLock\Model\IpLock
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function check(): void
    {
        $this->actionHandle(Check::class);
    }

    /**
     * @return ?\App\Domains\IpLock\Model\IpLock
     */
    public function create(): ?Model
    {
        return $this->actionHandle(Create::class);
    }

    /**
     * @return \App\Domains\IpLock\Model\IpLock
     */
    public function updateEndAt(): Model
    {
        return $this->actionHandle(UpdateEndAt::class);
    }
}
