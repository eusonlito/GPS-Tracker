<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Action;

use App\Domains\Core\Action\ActionAbstract as ActionAbstractCore;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @return int
     */
    protected function userId(): int
    {
        if ($this->row?->user_id) {
            return $this->row->user_id;
        }

        if ($this->auth->managerMode() && ($this->data['user_id'] ?? false)) {
            return $this->data['user_id'];
        }

        return $this->auth->id;
    }

    /**
     * @return void
     */
    protected function dataUserId(): void
    {
        $this->data['user_id'] = $this->userId();
    }
}
