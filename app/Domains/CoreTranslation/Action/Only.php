<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Action;

use App\Domains\CoreTranslation\Service\Only as ActionService;

class Only extends ActionAbstract
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return ActionService::new($this->data['lang'])->scan();
    }
}
