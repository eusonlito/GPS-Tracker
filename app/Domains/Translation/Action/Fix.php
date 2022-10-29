<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\Fix as FixService;

class Fix extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        FixService::new()->write();
    }
}
