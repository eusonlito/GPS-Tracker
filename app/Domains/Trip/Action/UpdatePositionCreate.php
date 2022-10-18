<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use Illuminate\Support\Collection;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Action\Traits\SaveRow as SaveRowTrait;
use App\Domains\Trip\Model\Trip as Model;

class UpdatePositionCreate extends ActionAbstract
{
    use SaveRowTrait;

    /**
     * @var \App\Domains\Trip\Model\Trip
     */
    protected Model $new;

    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $positions;

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->positions();
        $this->check();
        $this->create();
        $this->save();

        return $this->new;
    }

    /**
     * @return void
     */
    protected function positions(): void
    {
        $this->positions = $this->row->positions()
            ->byIds($this->data['position_ids'])
            ->list()
            ->get();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if ($this->positions->isEmpty()) {
            $this->exceptionValidator(__('trip-update-position-create.error.position_ids-empty'));
        }
    }

    /**
     * @return void
     */
    protected function create(): void
    {
        $this->new = $this->factory()->action($this->createData())->create();
    }

    /**
     * @return array
     */
    protected function createData(): array
    {
        return [
            'name' => $this->createDataName(),
            'start_at' => $this->createDataStartAt(),
            'start_utc_at' => $this->createDataStartUtcAt(),
            'end_at' => $this->createDataEndAt(),
            'end_utc_at' => $this->createDataEndUtcAt(),
            'device_id' => $this->row->device_id,
            'timezone_id' => $this->row->timezone_id,
            'user_id' => $this->row->user_id,
        ];
    }

    /**
     * @return string
     */
    protected function createDataName(): string
    {
        return implode(' - ', array_unique([$this->positions->first()->date_at, $this->positions->last()->date_at]));
    }

    /**
     * @return string
     */
    protected function createDataStartAt(): string
    {
        return $this->positions->first()->date_at;
    }

    /**
     * @return string
     */
    protected function createDataStartUtcAt(): string
    {
        return $this->positions->first()->date_utc_at;
    }

    /**
     * @return string
     */
    protected function createDataEndAt(): string
    {
        return $this->positions->last()->date_at;
    }

    /**
     * @return string
     */
    protected function createDataEndUtcAt(): string
    {
        return $this->positions->last()->date_utc_at;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveNew();
        $this->saveRow();
    }

    /**
     * @return void
     */
    protected function saveNew(): void
    {
        $this->saveNewPositions();
        $this->saveNewDistanceTime();
    }

    /**
     * @return void
     */
    protected function saveNewPositions(): void
    {
        PositionModel::byIds($this->positions->pluck('id')->all())
            ->update(['trip_id' => $this->new->id]);
    }

    /**
     * @return void
     */
    protected function saveNewDistanceTime(): void
    {
        $this->new->updateDistanceTime();
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->saveRowStartEnd();
        $this->saveRowName();
        $this->saveRowSave();
        $this->saveRowDistanceTime();
    }
}
