<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Action;

use App\Domains\Shared\Action\ActionFactoryAbstract;
use App\Domains\Vehicle\Model\Vehicle as Model;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Vehicle\Model\Vehicle
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Vehicle\Model\Vehicle
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
     * @return \App\Domains\Vehicle\Model\Vehicle
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Vehicle\Model\Vehicle
     */
    public function updateAlarm(): Model
    {
        return $this->actionHandle(UpdateAlarm::class, $this->validate()->updateAlarm());
    }
}
