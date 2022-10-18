<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

use App\Domains\Translation\Service\NotTranslated as NotTranslatedService;

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
        foreach ((new NotTranslatedService())->scan() as $status) {
            $this->info($status);
        }
    }
}
