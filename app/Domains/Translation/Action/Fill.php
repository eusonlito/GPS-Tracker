<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\Fill as ActionService;

class Fill extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        ActionService::new()->write();
    }
}
