<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\Only as ActionService;

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
