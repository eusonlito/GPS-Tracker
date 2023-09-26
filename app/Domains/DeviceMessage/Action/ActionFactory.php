<?php declare(strict_types=1);

namespace App\Domains\DeviceMessage\Action;

use App\Domains\DeviceMessage\Model\DeviceMessage as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\DeviceMessage\Model\DeviceMessage
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\DeviceMessage\Model\DeviceMessage
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
     * @return \App\Domains\DeviceMessage\Model\DeviceMessage
     */
    public function duplicate(): Model
    {
        return $this->actionHandle(Duplicate::class);
    }
}
