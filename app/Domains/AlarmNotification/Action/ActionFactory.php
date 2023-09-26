<?php declare(strict_types=1);

namespace App\Domains\AlarmNotification\Action;

use App\Domains\AlarmNotification\Model\AlarmNotification as Model;
use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\AlarmNotification\Model\AlarmNotification
     */
    protected ?Model $row;

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\AlarmNotification
     */
    public function notify(): Model
    {
        return $this->actionHandle(Notify::class);
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\AlarmNotification
     */
    public function updateClosedAt(): Model
    {
        return $this->actionHandle(UpdateClosedAt::class);
    }

    /**
     * @return \App\Domains\AlarmNotification\Model\AlarmNotification
     */
    public function updateSentAt(): Model
    {
        return $this->actionHandle(UpdateSentAt::class);
    }
}
