<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

use App\Domains\Translation\Service\Fix as FixService;

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
        (new FixService())->write();
    }
}
