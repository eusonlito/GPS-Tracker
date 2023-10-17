<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Command;

class PlainImport extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:translation:plain:import {--lang=} {--file=}';

    /**
     * @var string
     */
    protected $description = 'Import JSON translation {--file=} by {--lang=}';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->checkOptions(['lang', 'file']);
        $this->requestWithOptions();

        $this->info($this->action()->plainImport());

        $this->info('[END]');
    }
}
