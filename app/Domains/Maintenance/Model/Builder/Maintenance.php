<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Maintenance extends BuilderAbstract
{
    /**
     * @param string $date_at
     *
     * @return self
     */
    public function byDateAtDateAfter(string $date_at): self
    {
        return $this->whereDate('date_at', '>=', $date_at);
    }

    /**
     * @param string $date_at
     *
     * @return self
     */
    public function byDateAtDateBefore(string $date_at): self
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
    public function whenDateAtDateBeforeAfter(?string $before_date_at, ?string $after_date_at): self
    {
        return $this->whenDateAtDateBefore($before_date_at)->whenDateAtDateAfter($after_date_at);
    }

    /**
     * @param ?string $date_at
     *
     * @return self
     */
    public function whenDateAtDateAfter(?string $date_at): self
    {
        return $this->when($date_at, static fn ($q) => $q->byDateAtDateAfter($date_at));
    }

    /**
     * @param ?string $date_at
     *
     * @return self
     */
    public function whenDateAtDateBefore(?string $date_at): self
    {
        return $this->when($date_at, static fn ($q) => $q->byDateAtDateBefore($date_at));
    }

    /**
     * @param ?string $search
     *
     * @return self
     */
    public function whenSearch(?string $search): self
    {
        return $this->when($search, static fn ($q) => $q->searchLike(['name', 'workshop', 'description'], $search));
    }

    /**
     * @return self
     */
    public function withVehicle(): self
    {
        return $this->with('vehicle');
    }
}
