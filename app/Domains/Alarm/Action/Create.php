<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

use App\Domains\Alarm\Model\Alarm as Model;
use App\Domains\Alarm\Service\Type\Manager as TypeManager;

class Create extends CreateUpdateAbstract
{
    /**
     * @return void
     */
    protected function type(): void
    {
        $this->type = TypeManager::new()->factory($this->data['type'], $this->data['config']);
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'type' => $this->data['type'],
            'name' => $this->data['name'],
            'config' => $this->data['config'],
            'telegram' => $this->data['telegram'],
            'enabled' => $this->data['enabled'],
            'schedule_start' => $this->data['schedule_start'],
            'schedule_end' => $this->data['schedule_end'],
            'user_id' => $this->data['user_id'],
        ]);
    }
}
