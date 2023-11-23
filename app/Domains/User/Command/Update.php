<?php declare(strict_types=1);

namespace App\Domains\User\Command;

class Update extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'user:update {--id=} {--name=} {--email=} {--password=} {--admin} {--manager} {--enabled}';

    /**
     * @var string
     */
    protected $description = 'Update User with {--name=} {--email=} {--password=} {--admin} {--manager} {--enabled}';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->checkOptions(['id']);
        $this->requestWithOptions();

        $this->row();

        $this->requestMergeRow();

        $this->update();
        $this->output();

        $this->info('[END]');
    }

    /**
     * @return void
     */
    protected function update(): void
    {
        $this->row = $this->factory()->action()->update();
    }

    /**
     * @return void
     */
    protected function output(): void
    {
        $this->info(helper()->jsonEncode($this->row->only('id', 'name', 'email', 'admin', 'manager', 'enabled')));
    }
}
