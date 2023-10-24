<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Action;

use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\MaintenanceItem\Model\MaintenanceItem
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\MaintenanceItem\Model\MaintenanceItem
     */
    public function create(): Model
    {
        return $this->actionHandleTransaction(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandleTransaction(Delete::class);
    }

    /**
     * @return \App\Domains\MaintenanceItem\Model\MaintenanceItem
     */
    public function update(): Model
    {
        return $this->actionHandleTransaction(Update::class, $this->validate()->update());
    }
}
