<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\Translate as ActionService;

class Translate extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        ActionService::new($this->data['from'], $this->data['to'])->write();
    }
}
