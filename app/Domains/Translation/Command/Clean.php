<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

class Clean extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:clean';

    /**
     * @var string
     */
    protected $description = 'Clean non existing translations';

    /**
     * @return void
     */
    public function handle()
    {
        $this->info('[START]');

        $this->action()->clean();

        $this->info('[END]');
    }
}
