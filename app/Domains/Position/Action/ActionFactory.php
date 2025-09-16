<?php declare(strict_types=1);

namespace App\Domains\Position\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\Position\Model\Position as Model;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Position\Model\Position
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function create(): void
    {
        $this->actionHandle(Create::class, $this->validate()->create());
    }

    /**
     * @return \App\Domains\Position\Model\Position
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
