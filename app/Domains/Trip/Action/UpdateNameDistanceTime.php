<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Job\UpdateStats as UpdateStatsJob;
use App\Domains\Trip\Model\Trip as Model;

class UpdateNameDistanceTime extends ActionAbstract
{
    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->startAt();
        $this->endAt();
        $this->name();
        $this->save();
        $this->job();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function startAt(): void
    {
        if (empty($position = $this->positionFirst())) {
            return;
        }

        $this->row->start_at = $position->date_at;
        $this->row->start_utc_at = $position->date_utc_at;
    }

    /**
     * @return ?\App\Domains\Position\Model\Position
     */
    protected function positionFirst(): ?PositionModel
    {
        return PositionModel::query()
            ->selectOnly('date_at', 'date_utc_at')
            ->byTripId($this->row->id)
            ->orderByDateUtcAtAsc()
            ->first();
    }

    /**
     * @return void
     */
    protected function endAt(): void
    {
        if (empty($position = $this->positionLast())) {
            return;
        }

        $this->row->end_at = $position->date_at;
        $this->row->end_utc_at = $position->date_utc_at;
    }

    /**
     * @return ?\App\Domains\Position\Model\Position
     */
    protected function positionLast(): ?PositionModel
    {
        return PositionModel::query()
            ->selectOnly('date_at', 'date_utc_at')
            ->byTripId($this->row->id)
            ->orderByDateUtcAtDesc()
            ->first();
    }

    /**
     * @return void
     */
    protected function name(): void
    {
        if ($this->row->nameIsDefault()) {
            $this->row->name = $this->row->nameFromDates();
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveRow();
        $this->saveDistanceTime();
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row->save();
    }

    /**
     * @return void
     */
    protected function saveDistanceTime(): void
    {
        $this->row->updateDistanceTime();
    }

    /**
     * @return void
     */
    protected function job(): void
    {
        UpdateStatsJob::dispatch($this->row->id);
    }
}
