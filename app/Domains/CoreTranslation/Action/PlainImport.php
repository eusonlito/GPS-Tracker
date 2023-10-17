<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Action;

use App\Domains\CoreTranslation\Service\PlainImport as ActionService;

class PlainImport extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        ActionService::new($this->data['lang'], $this->data['file'])->write();
    }
}
