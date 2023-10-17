<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Command;

class NotTranslated extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:translation:not-translated';

    /**
     * @var string
     */
    protected $description = 'Search empty translations on app and views';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->info($this->action()->notTranslated());

        $this->info('[END]');
    }
}
