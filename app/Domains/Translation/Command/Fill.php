<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

use App\Domains\Translation\Service\Fill as FillService;

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
        (new FillService())->write();
    }
}
