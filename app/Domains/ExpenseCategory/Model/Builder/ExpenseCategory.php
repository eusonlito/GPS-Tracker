<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\User\Model\User as UserModel;

class ExpenseCategory extends BuilderAbstract
{
    /**
     * @param string $code
     *
     * @return self
     */
    public function byCode(string $code): self
    {
        return $this->where($this->addTable('code'), $code);
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function byName(string $name): self
    {
        return $this->where($this->addTable('name'), $name);
    }

    /**
     * @param \App\Domains\User\Model\User $user
     *
     * @return self
     */
    public function byUserOrManagerOrSystem(UserModel $user): self
    {
        if ($user->managerMode()) {
            return $this;
        }

        return $this->byUserIdOrNull($user->id);
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserIdOrNull(int $user_id): self
    {
        return $this->where(function ($q) use ($user_id) {
            $q->whereNull($this->addTable('user_id'))
                ->orWhere($this->addTable('user_id'), $user_id);
        });
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderByRaw('`user_id` IS NOT NULL')
            ->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function onlySelectable(): self
    {
        return $this->whereNull($this->addTable('code'));
    }

    /**
     * @return self
     */
    public function onlyUser(): self
    {
        return $this->onlySelectable()
            ->whereNotNull($this->addTable('user_id'));
    }

    /**
     * @param ?int $user_id
     *
     * @return self
     */
    public function whenUserIdOrNull(?int $user_id): self
    {
        return $this->when($user_id, fn ($q) => $q->byUserIdOrNull($user_id));
    }

    /**
     * @return self
     */
    public function withExpensesCount(): self
    {
        return $this->withCount('expenses');
    }
}
