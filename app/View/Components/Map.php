<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;
use Illuminate\View\View;

class Map extends Component
{
    /**
     * @param int $id
     * @param \Illuminate\Support\Collection $positions
     *
     * @return self
     */
    public function __construct(readonly public int $id, readonly public Collection $positions)
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
        return $this->positions->map->only(
            'id',
            'date_at',
            'latitude',
            'longitude',
            'speed',
            'signal',
            'created_at'
        )->toJson();
    }
}
