<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Action;

use App\Domains\Vehicle\Model\Vehicle as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'name' => $this->data['name'],
            'plate' => $this->data['plate'],
            'timezone_auto' => $this->data['timezone_auto'],
            'enabled' => $this->data['enabled'],
            'timezone_id' => $this->data['timezone_id'],
            'user_id' => $this->data['user_id'],
        ]);
    }
}
