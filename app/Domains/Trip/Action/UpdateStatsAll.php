<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use Illuminate\Support\Collection;
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
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        $q = Model::query();

        if ($this->data['overwrite'] === false) {
            $q->whenStatsEmpty();
        }

        return $q->get();
    }
}
