<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\NotTranslated as NotTranslatedService;

class NotTranslated extends ActionAbstract
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return NotTranslatedService::new()->scan();
    }
}
