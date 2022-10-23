<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Domains\Trip\Model\Trip as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\Trip\Model\Trip
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function create(): Model
    {
        return $this->actionHandle(Create::class, $this->validate()->create());
    }

    /**
     * @return ?\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(): ?StreamedResponse
    {
        return $this->actionHandle(Export::class);
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function lastOrNew(): Model
    {
        return $this->actionHandle(LastOrNew::class, $this->validate()->lastOrNew());
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function update(): Model
    {
        return $this->actionHandle(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function updateMerge(): Model
    {
        return $this->actionHandle(UpdateMerge::class, $this->validate()->updateMerge());
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function updateNameDistanceTime(): Model
    {
        return $this->actionHandle(UpdateNameDistanceTime::class);
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function updatePositionCreate(): Model
    {
        return $this->actionHandle(UpdatePositionCreate::class, $this->validate()->updatePositionCreate());
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function updatePositionDelete(): Model
    {
        return $this->actionHandle(UpdatePositionDelete::class, $this->validate()->updatePositionDelete());
    }
}
