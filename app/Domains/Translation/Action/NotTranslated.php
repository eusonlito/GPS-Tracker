<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\NotTranslated as ActionService;

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
