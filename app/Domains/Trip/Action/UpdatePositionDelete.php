<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Trip\Model\Trip as Model;

class UpdatePositionDelete extends ActionAbstract
{
    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->delete();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->row->positions()->byIds($this->data['position_ids'])->delete();
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->factory()->action()->updateNameDistanceTime();
    }
}
