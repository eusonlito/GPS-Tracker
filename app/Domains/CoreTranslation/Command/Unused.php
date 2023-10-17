<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Command;

class Unused extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:translation:unused';

    /**
     * @var string
     */
    protected $description = 'Delete unused translation files';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->action()->unused();

        $this->info('[END]');
    }
}
