<?php declare(strict_types=1);

namespace App\Domains\Position\Job;

class UpdateCity extends JobAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->factory(row: $this->row())->action()->updateCity();
    }
}
