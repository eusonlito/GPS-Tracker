<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

class NotTranslated extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:not-translated';

    /**
     * @var string
     */
    protected $description = 'Search empty translations on app and views';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->info($this->action()->notTranslated());

        $this->info('[END]');
    }
}
