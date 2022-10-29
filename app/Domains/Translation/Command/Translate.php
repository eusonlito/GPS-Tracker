<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

class Translate extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:translate {--from=} {--to=}';

    /**
     * @var string
     */
    protected $description = 'Translate to lang using online translator';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->checkOptions(['from', 'to']);
        $this->requestWithOptions();

        $this->action()->translate();

        $this->info('[END]');
    }
}
