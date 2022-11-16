<?php declare(strict_types=1);

namespace App\Domains\DeviceAlarm\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;
use App\Domains\Device\Model\Device as DeviceModel;

class DeviceAlarm extends BuilderAbstract
{
    /**
     * @param int $device_id
     *
     * @return self
     */
    public function byDeviceId(int $device_id): self
    {
        return $this->where('device_id', $device_id);
    }

    /**
     * @param int $device_id
     *
     * @return self
     */
    public function byDeviceIdEnabled(int $device_id): self
    {
        return $this->whereIn('device_id', DeviceModel::query()->select('id')->byId($device_id)->enabled());
    }

    /**
     * @param string $serial
     *
     * @return self
     */
    public function byDeviceSerial(string $serial): self
    {
        return $this->whereIn('device_id', DeviceModel::query()->select('id')->bySerial($serial));
    }

    /**
     * @return self
     */
    public function withDevice(): self
    {
        return $this->with('device');
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
