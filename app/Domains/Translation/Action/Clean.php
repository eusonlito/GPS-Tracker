<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\Clean as ActionService;

class Clean extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        ActionService::new()->write();
    }
}
