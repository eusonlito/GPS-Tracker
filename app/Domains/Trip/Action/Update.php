<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Trip\Model\Trip as Model;

class Update extends ActionAbstract
{
    /**
     * @return \App\Domains\Trip\Model\Trip
     */
    public function handle(): Model
    {
        $this->saveName();
        $this->saveNameDistanceTime();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function saveName(): void
    {
        $this->row->name = $this->data['name'];
        $this->row->save();
    }

    /**
     * @return void
     */
    protected function saveNameDistanceTime(): void
    {
        $this->factory()->action()->updateNameDistanceTime();
    }
}
