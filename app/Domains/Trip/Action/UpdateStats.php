<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as Model;

class UpdateStats extends ActionAbstract
{
    /**
     * @var array
     */
    protected array $stats;

    /**
     * @var \App\Domains\Position\Model\Collection\Position
     */
    protected PositionCollection $positions;

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->stats();
        $this->positions();
        $this->iterate();
        $this->finish();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function stats(): void
    {
        $this->stats = [
            'speed' => [
                'max' => 0,
                'min' => 0,
                'avg' => 0,
                'avg_movement' => 0,

                'max_percent' => 0,
                'min_percent' => 0,
                'avg_percent' => 0,
                'avg_movement_percent' => 0,
            ],

            'time' => [
                'total' => 0,
                'movement' => 0,
                'stopped' => 0,

                'total_percent' => 0,
                'movement_percent' => 0,
                'stopped_percent' => 0,
            ],
        ];
    }

    /**
     * @return void
     */
    protected function positions(): void
    {
        $this->positions = PositionModel::query()
            ->selectOnly('speed', 'date_at')
            ->byTripId($this->row->id)
            ->orderByDateUtcAtAsc()
            ->get();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->positions as $i => $position) {
            $this->position($position, $this->positions->get($i - 1));
        }
    }

    /**
     * @param \App\Domains\Position\Model\Position $position
     * @param ?\App\Domains\Position\Model\Position $previous
     *
     * @return void
     */
    protected function position(PositionModel $position, ?PositionModel $previous): void
    {
        if ($previous) {
            $seconds = strtotime($position->date_at) - strtotime($previous->date_at);
        } else {
            $seconds = 0;
        }

        if (($previous ?: $position)->speed) {
            $this->stats['time']['movement'] += $seconds;
        } else {
            $this->stats['time']['stopped'] += $seconds;
        }
    }

    /**
     * @return void
     */
    protected function finish(): void
    {
        $this->finishTime();
        $this->finishSpeed();
    }

    /**
     * @return void
     */
    protected function finishSpeed(): void
    {
        $max = round($this->positions->max('speed') ?: 0, 2);

        if ($max === 0.0) {
            return;
        }

        $min = round($this->positions->min('speed') ?: 0, 2);

        if ($this->row->time) {
            $avg = round($this->row->distance / $this->row->time * 3.6, 2);
        } else {
            $avg = 0;
        }

        if ($this->stats['time']['movement']) {
            $avg_movement = round($this->row->distance / $this->stats['time']['movement'] * 3.6, 2);
        } else {
            $avg_movement = 0;
        }

        $max_percent = 100;
        $min_percent = (int)round($min * 100 / $max, 0);
        $avg_percent = (int)round($avg * 100 / $max, 0);
        $avg_movement_percent = (int)round($avg_movement * 100 / $max, 0);

        $this->stats['speed'] = get_defined_vars();
    }

    /**
     * @return void
     */
    protected function finishTime(): void
    {
        $movement = $this->stats['time']['movement'];
        $stopped = $this->stats['time']['stopped'];
        $total = $movement + $stopped;

        if ($total === 0) {
            return;
        }

        $total_percent = 100;
        $movement_percent = (int)round($movement * 100 / $total, 0);
        $stopped_percent = (int)round($stopped * 100 / $total, 0);

        $this->stats['time'] = get_defined_vars();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row->stats = $this->stats;
        $this->row->save();
    }
}
