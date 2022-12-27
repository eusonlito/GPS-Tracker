<?php declare(strict_types=1);

namespace App\Domains\Server\Action;

use App\Domains\Server\Model\Server as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'port' => $this->data['port'],
            'protocol' => $this->data['protocol'],
            'debug' => $this->data['debug'],
            'enabled' => $this->data['enabled'],
        ]);
    }
}
