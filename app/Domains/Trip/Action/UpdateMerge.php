<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as Model;

class UpdateMerge extends ActionAbstract
{
    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->save();
        $this->delete();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataIds();
    }

    /**
     * @return void
     */
    protected function dataIds(): void
    {
        $this->data['ids'] = Model::query()
            ->byUserId($this->row->user_id)
            ->byIdNot($this->row->id)
            ->byIds($this->data['ids'])
            ->pluck('id')
            ->all();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (empty($this->data['ids'])) {
            $this->exceptionValidator(__('trip-update-merge.error.ids-empty'));
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->savePosition();
        $this->saveRow();
    }

    /**
     * @return void
     */
    protected function savePosition(): void
    {
        PositionModel::query()
            ->byTripIds($this->data['ids'])
            ->update(['trip_id' => $this->row->id]);
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->factory()->action()->updateNameDistanceTime();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        Model::query()
            ->byIds($this->data['ids'])
            ->delete();
    }
}
