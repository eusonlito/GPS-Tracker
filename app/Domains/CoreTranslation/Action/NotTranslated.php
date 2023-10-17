<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Action;

use App\Domains\CoreTranslation\Service\NotTranslated as ActionService;

class NotTranslated extends ActionAbstract
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return ActionService::new()->scan();
    }
}
