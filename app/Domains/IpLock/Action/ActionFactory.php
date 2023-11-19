<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\IpLock\Model\IpLock as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

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
        $this->actionHandle(Check::class, $this->validate()->check());
    }

    /**
     * @return \App\Domains\IpLock\Model\IpLock
     */
    public function create(): Model
    {
        return $this->actionHandle(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return ?\App\Domains\IpLock\Model\IpLock
     */
    public function lock(): ?Model
    {
        return $this->actionHandle(Lock::class, $this->validate()->lock());
    }

    /**
     * @return \App\Domains\IpLock\Model\IpLock
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\IpLock\Model\IpLock
     */
    public function updateEndAt(): Model
    {
        return $this->actionHandle(UpdateEndAt::class);
    }
}
