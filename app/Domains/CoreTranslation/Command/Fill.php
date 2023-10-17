<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Command;

class Fill extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:translation:fill';

    /**
     * @var string
     */
    protected $description = 'Fill PHP files with translation codes';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->action()->fill();

        $this->info('[END]');
    }
}
