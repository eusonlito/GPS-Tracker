<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

use App\Domains\Translation\Service\Translate as TranslateService;

class Translate extends CommandAbstract
{
    /**
     * @var string
     */
    protected $signature = 'translation:translate {lang}';

    /**
     * @var string
     */
    protected $description = 'Translate to lang using online translator';

    /**
     * @return void
     */
    public function handle()
    {
        (new TranslateService((string)$this->argument('lang')))->write();
    }
}
