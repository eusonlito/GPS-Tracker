<?php declare(strict_types=1);

namespace App\Domains\Alarm\Model\Builder;

use App\Domains\Alarm\Model\AlarmDevice as AlarmDeviceModel;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Alarm extends BuilderAbstract
{
    /**
     * @param int $device_id
     *
     * @return self
     */
    public function byDeviceId(int $device_id): self
    {
        return $this->whereIn('id', AlarmDeviceModel::query()->selectOnly('alarm_id')->byDeviceId($device_id));
    }

    /**
     * @param int $device_id
     *
     * @return self
     */
    public function byDeviceIdEnabled(int $device_id): self
    {
        return $this->whereIn('id', AlarmDeviceModel::query()->selectOnly('alarm_id')->byDeviceIdEnabled($device_id));
    }

    /**
     * @param string $serial
     *
     * @return self
     */
    public function byDeviceSerial(string $serial): self
    {
        return $this->whereIn('id', AlarmDeviceModel::query()->selectOnly('alarm_id')->byDeviceSerial($serial));
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->whereIn('id', AlarmDeviceModel::query()->selectOnly('alarm_id')->byUserId($user_id));
    }

    /**
     * @return self
     */
    public function withDevices(): self
    {
        return $this->with(['devices' => static fn ($q) => $q->withTimeZone()]);
    }

    /**
     * @return self
     */
    public function withNotificationsCount(): self
    {
        return $this->withCount('notifications');
    }

    /**
     * @return self
     */
    public function withNotificationsPendingCount(): self
    {
        return $this->withCount(['notifications as notifications_pending_count' => static fn ($q) => $q->whereClosedAt()]);
    }
}
