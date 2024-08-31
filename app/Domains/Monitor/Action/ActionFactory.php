<?php declare(strict_types=1);

namespace App\Domains\Monitor\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @return void
     */
    public function queueFailedRetry(): void
    {
        $this->actionHandle(QueueFailedRetry::class, $this->validate()->queueFailedRetry());
    }
}
