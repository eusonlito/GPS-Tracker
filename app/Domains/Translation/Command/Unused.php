<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

class Unused extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:unused';

    /**
     * @var string
     */
    protected $description = 'Delete unused translation files';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->action()->unused();

        $this->info('[END]');
    }
}
