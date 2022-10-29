<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\Translate as TranslateService;

class Translate extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        TranslateService::new($this->data['from'], $this->data['to'])->write();
    }
}
