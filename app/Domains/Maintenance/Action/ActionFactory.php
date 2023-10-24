<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

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
     * @return \App\Domains\Maintenance\Model\Maintenance
     */
    public function update(): Model
    {
        return $this->actionHandleTransaction(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Maintenance\Model\Maintenance
     */
    public function updateItem(): Model
    {
        return $this->actionHandleTransaction(UpdateItem::class, $this->validate()->updateItem());
    }
}
