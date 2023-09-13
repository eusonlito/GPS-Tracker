<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Maintenance\Model\Maintenance
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Maintenance\Model\Maintenance
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
     * @return \App\Domains\Maintenance\Model\Maintenance
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Alarm\Model\Alarm
     */
    public function updateBoolean(): Model
    {
        return $this->actionHandle(UpdateBoolean::class, $this->validate()->updateBoolean());
    }
}
