<?php declare(strict_types=1);

namespace App\Domains\File\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class File extends BuilderAbstract
{
    /**
     * @param string $related_table
     * @param int $related_id
     *
     * @return self
     */
    public function byRelated(string $related_table, int $related_id): self
    {
        return $this->byRelatedTable($related_table)->byRelatedId($related_id);
    }

    /**
     * @param int $related_id
     *
     * @return self
     */
    public function byRelatedId(int $related_id): self
    {
        return $this->where('related_id', $related_id);
    }

    /**
     * @param string $related_table
     *
     * @return self
     */
    public function byRelatedTable(string $related_table): self
    {
        return $this->where('related_table', $related_table);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('id', 'ASC');
    }
}
