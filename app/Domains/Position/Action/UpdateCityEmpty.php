<?php declare(strict_types=1);

namespace App\Domains\Position\Action;

use App\Domains\Position\Job\UpdateCity as UpdateCityJob;
use App\Domains\Position\Model\Position as Model;

class UpdateCityEmpty extends ActionAbstract
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
            UpdateCityJob::dispatch($id);
        }
    }

    /**
     * @return array
     */
    protected function ids(): array
    {
        return Model::query()
            ->withoutCity()
            ->orderByDateUtcAtDesc()
            ->pluck('id')
            ->all();
    }
}
