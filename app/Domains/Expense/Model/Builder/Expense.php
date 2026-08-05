<?php declare(strict_types=1);

namespace App\Domains\Expense\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class Expense extends BuilderAbstract
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
     * @param int $expense_category_id
     *
     * @return self
     */
    public function byExpenseCategoryId(int $expense_category_id): self
    {
        return $this->where($this->addTable('expense_category_id'), $expense_category_id);
    }

    /**
     * @param int $maintenance_id
     *
     * @return self
     */
    public function byMaintenanceId(int $maintenance_id): self
    {
        return $this->where($this->addTable('maintenance_id'), $maintenance_id);
    }

    /**
     * @param int $refuel_id
     *
     * @return self
     */
    public function byRefuelId(int $refuel_id): self
    {
        return $this->where($this->addTable('refuel_id'), $refuel_id);
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
    public function orderByDateAtAsc(): self
    {
        return $this->orderBy('date_at', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByDateAtDesc(): self
    {
        return $this->orderBy('date_at', 'DESC');
    }

    /**
     * @param ?string $before_date_at
     * @param ?string $after_date_at
     *
     * @return self
     */
    public function whenDateAtBetween(?string $before_date_at, ?string $after_date_at): self
    {
        return $this->whenDateAtAfter($before_date_at)->whenDateAtBefore($after_date_at);
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
     * @param ?int $expense_category_id
     *
     * @return self
     */
    public function whenExpenseCategoryId(?int $expense_category_id): self
    {
        return $this->when($expense_category_id, fn ($q) => $q->byExpenseCategoryId($expense_category_id));
    }

    /**
     * @param ?string $search
     *
     * @return self
     */
    public function whenSearch(?string $search): self
    {
        return $this->when($search, fn ($q) => $q->searchLike(['name', 'description'], $search));
    }

    /**
     * @return self
     */
    public function withCategory(): self
    {
        return $this->with('category');
    }

    /**
     * @return self
     */
    public function withVehicle(): self
    {
        return $this->with('vehicle');
    }
}
