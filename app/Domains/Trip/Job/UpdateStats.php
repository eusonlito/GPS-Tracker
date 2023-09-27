<?php declare(strict_types=1);

namespace App\Domains\Trip\Job;

class UpdateStats extends JobAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->factory(row: $this->row())->action()->updateStats();
    }
}
