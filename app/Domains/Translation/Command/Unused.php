<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

use App\Domains\Translation\Service\Unused as UnusedService;

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
        (new UnusedService())->write();
    }
}
