<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\Server\Model\Server as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Server\Model\Server
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Server\Model\Server
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
     * @return void
     */
    public function logRead(): void
    {
        $this->actionHandle(LogRead::class, $this->validate()->logRead());
    }

    /**
     * @return array
     */
    public function parse(): array
    {
        return $this->actionHandle(Parse::class, $this->validate()->parse());
    }

    /**
     * @return void
     */
    public function startAll(): void
    {
        $this->actionHandle(StartAll::class, $this->validate()->startAll());
    }

    /**
     * @return void
     */
    public function startPort(): void
    {
        $this->actionHandle(StartPort::class, $this->validate()->startPort());
    }

    /**
     * @return void
     */
    public function startPorts(): void
    {
        $this->actionHandle(StartPorts::class, $this->validate()->startPorts());
    }

    /**
     * @return void
     */
    public function stopAll(): void
    {
        $this->actionHandle(StopAll::class);
    }

    /**
     * @return void
     */
    public function stopPorts(): void
    {
        $this->actionHandle(StopPorts::class, $this->validate()->stopPorts());
    }

    /**
     * @return \App\Domains\Server\Model\Server
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Server\Model\Server
     */
    public function updateBoolean(): Model
    {
        return $this->actionHandle(UpdateBoolean::class, $this->validate()->updateBoolean());
    }
}
