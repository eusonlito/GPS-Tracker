<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

class Fill extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:fill';

    /**
     * @var string
     */
    protected $description = 'Fill PHP files with translation codes';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->action()->fill();

        $this->info('[END]');
    }
}
