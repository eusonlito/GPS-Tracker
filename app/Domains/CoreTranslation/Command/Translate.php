<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Command;

class Translate extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:translation:translate {--from=} {--to=*}';

    /**
     * @var string
     */
    protected $description = 'Translate to languages using online translator';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->checkOptions(['from', 'to']);
        $this->requestWithOptions();

        $this->action()->translate();

        $this->info('[END]');
    }
}
