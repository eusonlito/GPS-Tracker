<?php declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Position\Model\Position as PositionModel;

class ChartSpeed extends Component
{
    /**
     * @param \App\Domains\Position\Model\Collection\Position $positions
     *
     * @return self
     */
    public function __construct(readonly public PositionCollection $positions)
    {
    }

    /**
     * @return bool
     */
    public function shouldRender(): bool
    {
        return $this->positions->isNotEmpty();
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render(): View
    {
        return view('components.chart-speed', [
            'id' => 'chart_speed_'.uniqid(),
            'positionsJson' => $this->positionsJson(),
        ]);
    }

    /**
     * @return string
     */
    protected function positionsJson(): string
    {
        return $this->positions
            ->toBase()
            ->sortBy('date_at')
            ->map($this->positionsJsonMap(...))
            ->values()
            ->toJson();
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     *
     * @return array
     */
    protected function positionsJsonMap(PositionModel $position): array
    {
        return [
            'id' => $position->id,
            'date_at' => explode(' ', $position->date_at)[1],
            'speed' => helper()->unit('speed', $position->speed),
        ];
    }
}
