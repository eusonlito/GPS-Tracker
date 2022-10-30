<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as TripModel;

class Map extends Component
{
    /**
     * @param \App\Domains\Trip\Model\Trip $trip
     * @param \Illuminate\Support\Collection $positions
     *
     * @return self
     */
    public function __construct(readonly public TripModel $trip, readonly public Collection $positions)
    {
    }

    /**
     * @return ?\Illuminate\View\View
     */
    public function render(): ?View
    {
        if ($this->positions->isEmpty()) {
            return null;
        }

        return view('components.map', [
            'json' => $this->json(),
        ]);
    }

    /**
     * @return string
     */
    protected function json(): string
    {
        return $this->positions->map(fn ($position) => $this->jsonMap($position))->toJson();
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return array
     */
    protected function jsonMap(PositionModel $position): array
    {
        return $position->only('id', 'date_at', 'latitude', 'longitude', 'speed', 'signal', 'created_at')
            + ['city' => $position->city->name, 'state' => $position->city->state->name];
    }
}
