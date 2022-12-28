<?php declare(strict_types=1);

namespace App\Domains\Trip\Command;

class UpdateStatsAll extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'trip:update:stats:all';

    /**
     * @var string
     */
    protected $description = 'Update All Trip Stats';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->factory()->action()->updateStatsAll();

        $this->info('[END]');
    }
}
