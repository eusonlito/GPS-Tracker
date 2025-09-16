<?php declare(strict_types=1);

namespace App\Domains\Device\Action;

use App\Domains\CoreApp\Action\UpdateBoolean as UpdateBooleanCoreApp;
use App\Domains\Device\Model\Device as Model;

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
        $this->row->code = $this->row->code ?: helper()->uuid();
    }
}
