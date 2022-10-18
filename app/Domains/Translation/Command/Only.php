<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

use App\Domains\Translation\Service\Only as OnlyService;

class Only extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:only {lang}';

    /**
     * @var string
     */
    protected $description = 'Search translations only in one language';

    /**
     * @return void
     */
    public function handle()
    {
        foreach ((new OnlyService((string)$this->argument('lang')))->scan() as $status) {
            $this->info($status);
        }
    }
}
