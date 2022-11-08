<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Device\Model\Device
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Device\Model\Device
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
     * @return \App\Domains\Device\Model\Device
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Device\Model\Device
     */
    public function updateDeviceMessageCreate(): Model
    {
        return $this->actionHandle(UpdateDeviceMessageCreate::class);
    }

    /**
     * @return \App\Domains\Device\Model\Device
     */
    public function updateDeviceMessageDelete(): Model
    {
        return $this->actionHandle(UpdateDeviceMessageDelete::class, $this->validate()->updateDeviceMessageDelete());
    }
}
