<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\Only as OnlyService;

class Only extends ActionAbstract
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return OnlyService::new($this->data['lang'])->scan();
    }
}
