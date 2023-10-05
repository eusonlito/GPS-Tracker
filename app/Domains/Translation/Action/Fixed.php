<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\Fixed as ActionService;

class Fixed extends ActionAbstract
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return ActionService::new($this->data['paths-exclude'])->scan();
    }
}
