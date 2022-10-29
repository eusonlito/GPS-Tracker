<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\Fixed as FixedService;

class Fixed extends ActionAbstract
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return FixedService::new($this->data['paths-exclude'])->scan();
    }
}
