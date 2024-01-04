<?php declare(strict_types=1);

namespace App\Domains\Position\Command;

class UpdateCity extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'position:update:city {--id=}';

    /**
     * @var string
     */
    protected $description = 'Update Position with Empty City';

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
