<?php declare(strict_types=1);

namespace App\Domains\Socket\Action;

use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @return void
     */
    public function killPorts(): void
    {
        $this->actionHandle(KillPorts::class, $this->validate()->killPorts());
    }

    /**
     * @return void
     */
    public function logRead(): void
    {
        $this->actionHandle(LogRead::class, $this->validate()->logRead());
    }

    /**
     * @return void
     */
    public function server(): void
    {
        $this->actionHandle(Server::class, $this->validate()->server());
    }

    /**
     * @return void
     */
    public function serverAll(): void
    {
        $this->actionHandle(ServerAll::class, $this->validate()->serverAll());
    }

    /**
     * @return void
     */
    public function serverPorts(): void
    {
        $this->actionHandle(ServerPorts::class, $this->validate()->serverPorts());
    }
}
