<?php declare(strict_types=1);

namespace App\Domains\Refuel\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Refuel extends BuilderAbstract
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
     * @param int $month
     *
     * @return self
     */
    public function byMonth(int $month): self
    {
        return $this->whereMonth('date_at', $month);
    }

    /**
     * @param int $year
     *
     * @return self
     */
    public function byYear(int $year): self
    {
        return $this->whereYear('date_at', $year);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderByDateAtDesc();
    }

    /**
     * @return self
     */
    public function orderByDateAtDesc(): self
    {
        return $this->orderBy('date_at', 'DESC');
    }

    /**
     * @return self
     */
    public function orderByDateAtAsc(): self
    {
        return $this->orderBy('date_at', 'ASC');
    }

    /**
     * @return self
     */
    public function selectDateAtAsYear(): self
    {
        return $this->selectRaw('YEAR(`date_at`) `year`');
    }

    /**
     * @param ?int $device_id
     *
     * @return self
     */
    public function whenDeviceId(?int $device_id): self
    {
        return $this->when($device_id, static fn ($q) => $q->byDeviceId($device_id));
    }

    /**
     * @param ?int $month
     *
     * @return self
     */
    public function whenMonth(?int $month): self
    {
        return $this->when($month, static fn ($q) => $q->byMonth($month));
    }

    /**
     * @param ?int $year
     *
     * @return self
     */
    public function whenYear(?int $year): self
    {
        return $this->when($year, static fn ($q) => $q->byYear($year));
    }

    /**
     * @return self
     */
    public function withDevice(): self
    {
        return $this->with('device');
    }
}
