<?php

declare(strict_types=1);

namespace App\Domains\Role\Action;

use App\Domains\Role\Model\Role as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Role\Model\Role
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function checkPosition(): void
    {
        $this->actionHandle(CheckPosition::class, $this->validate()->checkPosition());
    }

    /**
     * @return \App\Domains\Role\Model\Role
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
     * @return \App\Domains\Role\Model\Role
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Role\Model\Role
     */
    public function updateBoolean(): Model
    {
        return $this->actionHandle(UpdateBoolean::class, $this->validate()->updateBoolean());
    }

    /**
     * @return \App\Domains\Role\Model\Role
     */
    public function updateVehicle(): Model
    {
        return $this->actionHandle(UpdateVehicle::class, $this->validate()->updateVehicle());
    }
}
