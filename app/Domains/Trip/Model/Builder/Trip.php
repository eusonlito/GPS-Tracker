<?php declare(strict_types=1);

namespace App\Domains\Trip\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Trip extends BuilderAbstract
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
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtNext(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '>', $start_utc_at)->orderBy('start_utc_at', 'ASC');
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function byStartUtcAtPrevious(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '<', $start_utc_at)->orderBy('start_utc_at', 'DESC');
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('start_utc_at', 'DESC');
    }

    /**
     * @param string $start_utc_at
     *
     * @return self
     */
    public function nearToStartUtcAt(string $start_utc_at): self
    {
        return $this->where('start_utc_at', '<=', $start_utc_at)->orderBy('start_utc_at', 'DESC');
    }

    /**
     * @return self
     */
    public function withTimezone(): self
    {
        return $this->with('timezone');
    }
}
