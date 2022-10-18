<?php declare(strict_types=1);

namespace App\Domains\Position\Action;

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
        foreach (Model::selectPointAsLatitudeLongitude()->withoutCity()->orderByDateUtcAtAsc()->get() as $row) {
            $this->factory(row: $row)->action()->updateCity();
        }
    }
}
