<?php declare(strict_types=1);

namespace App\Domains\Translation\Command;

use App\Domains\Translation\Service\Clean as CleanService;

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
        (new CleanService())->write();
    }
}
