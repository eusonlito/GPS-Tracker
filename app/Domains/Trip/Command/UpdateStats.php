<?php declare(strict_types=1);

namespace App\Domains\Trip\Command;

class UpdateStats extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'trip:update:stats {--id=}';

    /**
     * @var string
     */
    protected $description = 'Update Trip Stats by {--id=}';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->checkOptions(['id']);
        $this->requestWithOptions();

        $this->row();

        $this->update();
        $this->output();

        $this->info('[END]');
    }

    /**
     * @return void
     */
    protected function update(): void
    {
        $this->factory()->action()->updateStats();
    }

    /**
     * @return void
     */
    protected function output(): void
    {
        $this->info(helper()->jsonEncode($this->row->stats));
    }
}
