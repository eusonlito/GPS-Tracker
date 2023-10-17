<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Action;

use App\Domains\CoreTranslation\Service\Unused as ActionService;

class Unused extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        ActionService::new()->write();
    }
}
