<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use Illuminate\Support\Collection;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as Model;

class UpdateStats extends ActionAbstract
{
    /**
     * @var array
     */
    protected array $stats;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $positions;

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
                'avg' => 0,
                'max' => 0,
                'min' => 0,
            ],

            'time' => [
                'movement' => 0,
                'stopped' => 0,
            ],
        ];
    }

    /**
     * @return void
     */
    protected function positions(): void
    {
        $this->positions = $this->row->positions;
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        $previous = null;

        foreach ($this->positions as $position) {
            $this->position($position, $previous);

            $previous = $position;
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

        if ($position->speed) {
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
        $this->stats['speed']['avg'] = round($this->positions->avg('speed'), 2);
        $this->stats['speed']['max'] = round($this->positions->max('speed'), 2);
        $this->stats['speed']['min'] = round($this->positions->min('speed'), 2);
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
