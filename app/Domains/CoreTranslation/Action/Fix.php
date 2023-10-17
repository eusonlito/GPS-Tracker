<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Action;

use App\Domains\CoreTranslation\Service\Fix as ActionService;

class Fix extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        ActionService::new()->write();
    }
}
