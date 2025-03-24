<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Builder;

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
     * @param string $column
     *
     * @return string
     */
    public function wrap(string $column): string
    {
        return $this->getGrammar()->wrap($column);
    }

    /**
     * @param string|array $column
     *
     * @return string|array
     */
    public function addTable(string|array $column): string|array
    {
        $table = $this->getTable();

        if (is_string($column)) {
            return $table.'.'.$column;
        }

        return array_map(fn ($column) => $table.'.'.$column, $column);
    }

    /**
     * @param string|array $column
     *
     * @return string|array
     */
    public function addTableRaw(string|array $column): string|array
    {
        $table = $this->wrap($this->getTable());

        if (is_string($column)) {
            return $table.'.'.$this->wrap($column);
        }

        return array_map(fn ($column) => $table.'.'.$this->wrap($column), $column);
    }

    /**
     * @param string $created_at
     *
     * @return self
     */
    public function byCreatedAtAfter(string $created_at): self
    {
        return $this->where($this->addTable('created_at'), '>', $created_at);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byId(int $id): self
    {
        return $this->where($this->addTable('id'), $id);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byIdNext(int $id): self
    {
        return $this->where($this->addTable('id'), '>', $id);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byIdPrevious(int $id): self
    {
        return $this->where($this->addTable('id'), '<', $id);
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function byIdNot(int $id): self
    {
        return $this->where($this->addTable('id'), '!=', $id);
    }

    /**
     * @param array $ids
     *
     * @return self
     */
    public function byIds(array $ids): self
    {
        return $this->whereIntegerInRaw($this->addTable('id'), $ids);
    }

    /**
     * @param array $ids
     *
     * @return self
     */
    public function byIdsNot(array $ids): self
    {
        return $this->whereIntegerNotInRaw($this->addTable('id'), $ids);
    }

    /**
     * @param string $updated_at
     *
     * @return self
     */
    public function byUpdatedAtAfter(string $updated_at): self
    {
        return $this->where($this->addTable('updated_at'), '>', $updated_at);
    }

    /**
     * @param int $user_id
     *
     * @return self
     */
    public function byUserId(int $user_id): self
    {
        return $this->where($this->addTable('user_id'), $user_id);
    }

    /**
     * @param bool $enabled = true
     *
     * @return self
     */
    public function enabled(bool $enabled = true): self
    {
        return $this->where($this->addTable('enabled'), $enabled);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy($this->addTable('id'), 'DESC');
    }

    /**
     * @return self
     */
    public function orderByCreatedAtAsc(): self
    {
        return $this->orderBy($this->addTable('created_at'), 'ASC');
    }

    /**
     * @return self
     */
    public function orderByCreatedAtDesc(): self
    {
        return $this->orderBy($this->addTable('created_at'), 'DESC');
    }

    /**
     * @return self
     */
    public function orderByFirst(): self
    {
        return $this->orderBy($this->addTable('id'), 'ASC');
    }

    /**
     * @return self
     */
    public function orderByLast(): self
    {
        return $this->orderBy($this->addTable('id'), 'DESC');
    }

    /**
     * @return self
     */
    public function orderByUpdatedAtAsc(): self
    {
        return $this->orderBy($this->addTable('updated_at'), 'ASC');
    }

    /**
     * @return self
     */
    public function orderByUpdatedAtDesc(): self
    {
        return $this->orderBy($this->addTable('updated_at'), 'DESC');
    }

    /**
     * @param string $column
     * @param ?string $mode
     *
     * @return self
     */
    public function orderByColumn(string $column, ?string $mode): self
    {
        return $this->orderBy($column, $this->orderMode($mode));
    }

    /**
     * @param ?string $mode
     * @param string $default = 'ASC'
     *
     * @return string
     */
    public function orderMode(?string $mode, string $default = 'ASC'): string
    {
        return match ($mode = strtoupper($mode)) {
            'ASC', 'DESC' => $mode,
            default => $default,
        };
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
     * @return self
     */
    protected function searchLikeColumns(Builder $q, array $columns, string $search): self
    {
        foreach ($columns as $each) {
            $q->orWhere($this->addTable($each), 'LIKE', $search);
        }

        return $q;
    }

    /**
     * @param string $search
     *
     * @return ?string
     */
    protected function searchLikeString(string $search): ?string
    {
        $search = trim(preg_replace('/[^\p{L}0-9]/u', ' ', $search));
        $search = array_filter(explode(' ', $search), static fn ($value) => strlen($value) >= 2);

        return $search ? ('%'.implode('%', $search).'%') : null;
    }

    /**
     * @param ?array $ids
     *
     * @return self
     */
    public function whenIds(?array $ids): self
    {
        return $this->when($ids, fn ($q) => $q->byIds($ids));
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function whenIdNext(int $id): self
    {
        return $this->when($id, fn ($q) => $q->byIdNext($id));
    }

    /**
     * @param string $column
     * @param array $strings
     *
     * @return self
     */
    public function whereStringInRaw(string $column, array $strings): self
    {
        return $this->whereRaw($this->wrap($column).' '.$this->stringsIn($strings));
    }

    /**
     * @param string $column
     * @param array $strings
     *
     * @return self
     */
    public function orWhereStringInRaw(string $column, array $strings): self
    {
        return $this->orWhereRaw($this->wrap($column).' '.$this->stringsIn($strings));
    }

    /**
     * @param array $strings
     *
     * @return string
     */
    protected function stringsIn(array $strings): string
    {
        return "IN ('".implode("', '", $this->strings($strings))."')";
    }

    /**
     * @param array $strings
     *
     * @return array
     */
    protected function strings(array $strings): array
    {
        return array_unique(array_filter(array_map(static function (mixed $string) {
            return trim(str_replace(['"', "'", '\\'], '', strval($string)));
        }, $strings)));
    }
}
