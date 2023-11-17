<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\Device\Model\Device as Model;
use App\Domains\CoreApp\Action\UpdateBoolean as UpdateBooleanCoreApp;

class UpdateBoolean extends UpdateBooleanCoreApp
{
    /**
     * @var \App\Domains\Device\Model\Device
     */
    protected Model $row;

    /**
     * @return void
     */
    protected function before(): void
    {
        if (config('demo.enabled') && ($this->row?->id === 1)) {
            $this->exceptionValidator(__('demo.error.not-allowed'));
        }

        $this->row->code = $this->row->code ?: helper()->uuid();
    }
}
