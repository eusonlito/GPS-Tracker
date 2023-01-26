<?php declare(strict_types=1);

namespace App\Domains\Shared\Model\Builder;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Builder;

abstract class BuilderAbstract extends Builder
{
    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected ConnectionInterface $db;

    /**
     * @var string
     */
    protected string $table;

    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function db(): ConnectionInterface
    {
        return $this->db ??= $this->getModel()->db();
    }

    /**
     * @return string
     */
    public function getTable(): string
    {
        return $this->table ??= $this->getModel()->getTable();
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byId(int $id): self
    {
        return $this->where($this->getTable().'.id', $id);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byIdNext(int $id): self
    {
        return $this->where('id', '>', $id);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byIdPrevious(int $id): self
    {
        return $this->where('id', '<', $id);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byIdNot(int $id): self
    {
        return $this->where($this->getTable().'.id', '!=', $id);
    }

    /**
     * @param array $ids
     *
     * @return self
     */
    public function byIds(array $ids): self
    {
        return $this->whereIntegerInRaw($this->getTable().'.id', $ids);
    }

    /**
     * @param array $ids
     *
     * @return self
     */
    public function byIdsNot(array $ids): self
    {
        return $this->orWhereIntegerNotInRaw($this->getTable().'.id', $ids);
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->where($this->getTable().'.user_id', $user_id);
    }

    /**
     * @param bool $enabled = true
     *
     * @return self
     */
    public function enabled(bool $enabled = true): self
    {
        return $this->where($this->getTable().'.enabled', $enabled);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy($this->getTable().'.id', 'DESC');
    }

    /**
     * @return self
     */
    public function orderByCreatedAtAsc(): self
    {
        return $this->orderBy($this->getTable().'.created_at', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByCreatedAtDesc(): self
    {
        return $this->orderBy($this->getTable().'.created_at', 'DESC');
    }

    /**
     * @return self
     */
    public function orderByFirst(): self
    {
        return $this->orderBy($this->getTable().'.id', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByLast(): self
    {
        return $this->orderBy($this->getTable().'.id', 'DESC');
    }

    /**
     * @return self
     */
    public function orderByUpdatedAtAsc(): self
    {
        return $this->orderBy($this->getTable().'.updated_at', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByUpdatedAtDesc(): self
    {
        return $this->orderBy($this->getTable().'.updated_at', 'DESC');
    }

    /**
     * @param string|array $column
     * @param string $search
     *
     * @return self
     */
    protected function searchLike(string|array $column, string $search): self
    {
        if ($search = $this->searchLikeString($search)) {
            $this->where(fn ($q) => $this->searchLikeColumns($q, (array)$column, $search));
        } else {
            $this->whereRaw('FALSE');
        }

        return $this;
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $q
     * @param array $columns
     * @param string $search
     *
     * @return void
     */
    private function searchLikeColumns(Builder $q, array $columns, string $search): void
    {
        foreach ($columns as $each) {
            $q->orWhere($this->getTable().'.'.$each, 'ILIKE', $search);
        }
    }

    /**
     * @param string $search
     *
     * @return ?string
     */
    protected function searchLikeString(string $search): ?string
    {
        $search = trim(preg_replace('/[^\p{L}0-9]/u', ' ', $search));
        $search = array_filter(explode(' ', $search), static fn ($value) => strlen($value) > 2);

        return $search ? ('%'.implode('%', $search).'%') : null;
    }

    /**
     * @param string ...$columns
     *
     * @return self
     */
    public function selectOnly(string ...$columns): self
    {
        return $this->select($columns);
    }

    /**
     * @param array $ids
     *
     * @return self
     */
    public function whenIds(array $ids): self
    {
        return $this->when($ids, static fn ($q) => $q->byIds($ids));
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function whenIdNext(int $id): self
    {
        return $this->when($id, static fn ($q) => $q->byIdNext($id));
    }
}
