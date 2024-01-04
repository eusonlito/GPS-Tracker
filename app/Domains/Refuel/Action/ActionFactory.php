<?php declare(strict_types=1);

namespace App\Domains\Refuel\Action;

use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Refuel\Model\Refuel
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Refuel\Model\Refuel
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
     * @return \App\Domains\Refuel\Model\Refuel
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Refuel\Model\Refuel
     */
    public function updateCity(): Model
    {
        return $this->actionHandle(UpdateCity::class);
    }

    /**
     * @return void
     */
    public function updateCityEmpty(): void
    {
        $this->actionHandle(UpdateCityEmpty::class);
    }
}
