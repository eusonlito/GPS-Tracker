<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

class Fix extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:fix';

    /**
     * @var string
     */
    protected $description = 'Fix PHP files with string translated same as code';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->action()->fix();

        $this->info('[END]');
    }
}
