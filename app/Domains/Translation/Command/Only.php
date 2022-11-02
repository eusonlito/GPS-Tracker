<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

class Only extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:only {--lang=}';

    /**
     * @var string
     */
    protected $description = 'Search translations only in one language';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->checkOptions(['lang']);
        $this->requestWithOptions();

        $this->info($this->action()->only());

        $this->info('[END]');
    }
}
