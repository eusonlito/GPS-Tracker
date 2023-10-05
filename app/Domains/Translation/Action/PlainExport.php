<?php declare(strict_types=1);

namespace App\Domains\Translation\Action;

use App\Domains\Translation\Service\PlainExport as ActionService;

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
