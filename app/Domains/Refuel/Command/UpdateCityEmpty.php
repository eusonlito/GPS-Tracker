<?php declare(strict_types=1);

namespace App\Domains\Refuel\Command;

class UpdateCityEmpty extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'refuel:update:city:empty';

    /**
     * @var string
     */
    protected $description = 'Update All Refuels with Empty City';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->factory()->action()->updateCityEmpty();

        $this->info('[END]');
    }
}
