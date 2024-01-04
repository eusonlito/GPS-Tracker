<?php declare(strict_types=1);

namespace App\Domains\Refuel\Command;

class UpdateCity extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'refuel:update:city {--id=}';

    /**
     * @var string
     */
    protected $description = 'Update Refuel with Empty City';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->checkOptions(['id']);
        $this->requestWithOptions();

        $this->row();

        $this->factory()->action()->updateCity();

        $this->info('[END]');
    }
}
