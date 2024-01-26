<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class Maintenance extends BuilderAbstract
{
    /**
     * @param string $date_at
     *
     * @return self
     */
    public function byDateAtAfter(string $date_at): self
    {
        return $this->whereDate('date_at', '>=', $date_at);
    }

    /**
     * @param string $date_at
     *
     * @return self
     */
    public function byDateAtBefore(string $date_at): self
    {
        return $this->whereDate('date_at', '<=', $date_at);
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
     * @param ?string $before_date_at
     * @param ?string $after_date_at
     *
     * @return self
     */
    public function whenDateAtBetween(?string $before_date_at, ?string $after_date_at): self
    {
        return $this->whenDateAtBefore($after_date_at)->whenDateAtAfter($before_date_at);
    }

    /**
     * @param ?string $date_at
     *
     * @return self
     */
    public function whenDateAtAfter(?string $date_at): self
    {
        return $this->when($date_at, fn ($q) => $q->byDateAtAfter($date_at));
    }

    /**
     * @param ?string $date_at
     *
     * @return self
     */
    public function whenDateAtBefore(?string $date_at): self
    {
        return $this->when($date_at, fn ($q) => $q->byDateAtBefore($date_at));
    }

    /**
     * @param ?string $search
     *
     * @return self
     */
    public function whenSearch(?string $search): self
    {
        return $this->when($search, fn ($q) => $q->searchLike(['name', 'workshop', 'description'], $search));
    }

    /**
     * @return self
     */
    public function withVehicle(): self
    {
        return $this->with('vehicle');
    }
}
