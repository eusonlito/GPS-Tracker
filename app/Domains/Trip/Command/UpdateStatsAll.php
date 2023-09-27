<?php declare(strict_types=1);

namespace App\Domains\Trip\Command;

class UpdateStatsAll extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'trip:update:stats:all {--force}';

    /**
     * @var string
     */
    protected $description = 'Update All Trip Stats with {--force}';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->requestWithOptions();
        $this->factory()->action()->updateStatsAll();

        $this->info('[END]');
    }
}
