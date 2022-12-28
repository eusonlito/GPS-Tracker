<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Trip\Job\UpdateStats as UpdateStatsJob;
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
        foreach ($this->ids() as $id) {
            UpdateStatsJob::dispatch($id);
        }
    }

    /**
     * @return array
     */
    protected function ids(): array
    {
        return Model::query()->pluck('id')->all();
    }
}
