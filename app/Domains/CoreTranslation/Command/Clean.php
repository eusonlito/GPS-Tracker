<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Command;

class Clean extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'core:translation:clean';

    /**
     * @var string
     */
    protected $description = 'Clean non existing translations';

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->info('[START]');

        $this->action()->clean();

        $this->info('[END]');
    }
}
