<?php declare(strict_types=1);

namespace App\Domains\Trip\Action;

use App\Domains\Trip\Model\Trip as Model;
use App\Domains\CoreApp\Action\UpdateBoolean as UpdateBooleanCoreApp;

class UpdateBoolean extends UpdateBooleanCoreApp
{
    /**
     * @var \App\Domains\Trip\Model\Trip
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
