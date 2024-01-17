<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Domains\Core\Action\ActionFactoryAbstract;
use App\Domains\Trip\Model\Trip as Model;

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
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function import(): Model
    {
        return $this->actionHandle(Import::class, $this->validate()->import());
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
    public function updateBoolean(): Model
    {
        return $this->actionHandle(UpdateBoolean::class, $this->validate()->updateBoolean());
    }

    /**
     * @return ?\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function updateExport(): ?StreamedResponse
    {
        return $this->actionHandle(UpdateExport::class);
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

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function updateStats(): Model
    {
        return $this->actionHandle(UpdateStats::class);
    }

    /**
     * @return void
     */
    public function updateStatsAll(): void
    {
        $this->actionHandle(UpdateStatsAll::class, $this->validate()->updateStatsAll());
    }
}
