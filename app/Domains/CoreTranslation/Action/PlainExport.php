<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Action;

use App\Domains\CoreTranslation\Service\PlainExport as ActionService;

class PlainExport extends ActionAbstract
{
    /**
     * @return string
     */
    public function handle(): string
    {
        return ActionService::new($this->data['lang'])->generate();
    }
}
