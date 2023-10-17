<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Action;

use App\Domains\CoreTranslation\Service\Translate as ActionService;

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
