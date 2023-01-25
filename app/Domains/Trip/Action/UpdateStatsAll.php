<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Trip\Model\Collection\Trip as Collection;
use App\Domains\Trip\Model\Trip as Model;

class UpdateStatsAll extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach ($this->list() as $row) {
            $this->factory(row: $row)->action()->updateStats();
        }
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function list(): Collection
    {
        $q = Model::query();

        if ($this->data['force'] === false) {
            $q->whenStatsEmpty();
        }

        return $q->get();
    }
}
