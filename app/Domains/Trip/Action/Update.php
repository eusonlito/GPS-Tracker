<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Trip\Action\Traits\SaveRow as SaveRowTrait;
use App\Domains\Trip\Model\Trip as Model;

class Update extends ActionAbstract
{
    use SaveRowTrait;

    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveName();

        $this->saveRowStartEnd();
        $this->saveRowName();
        $this->saveRowSave();
        $this->saveRowDistanceTime();
    }

    /**
     * @return void
     */
    protected function saveName(): void
    {
        $this->row->name = $this->data['name'];
    }
}
