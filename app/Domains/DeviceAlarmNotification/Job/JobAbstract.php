<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarmNotification\Job;

use Illuminate\Queue\Middleware\WithoutOverlapping;
use App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification as Model;
use App\Domains\Shared\Job\JobAbstract as JobAbstractShared;

abstract class JobAbstract extends JobAbstractShared
{
    /**
     * @param int $id
     *
     * @return void
     */
    public function __construct(protected int $id)
    {
    }

    /**
     * @return array
     */
    public function middleware()
    {
        return [(new WithoutOverlapping((string)$this->id))->expireAfter(30)];
    }

    /**
     * @return \App\Domains\DeviceAlarmNotification\Model\DeviceAlarmNotification
     */
    protected function row(): Model
    {
        return Model::query()->findOrFail($this->id);
    }
}
