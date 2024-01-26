<?php declare(strict_types=1);

namespace App\Domains\Language\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class Language extends BuilderAbstract
{
    /**
     * @param string $code
     *
     * @return self
     */
    public function byCode(string $code): self
    {
        return $this->where('code', $code);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderByRaw('IF (`code` = ?, TRUE, FALSE) DESC', config('app.locale'))
            ->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function selectSession(): self
    {
        return $this->select('id', 'code', 'name', 'locale');
    }

    /**
     * @param ?int $id
     *
     * @return self
     */
    public function whenIdOrDefault(?int $id): self
    {
        return $this->when($id, fn ($q) => $q->byId($id), fn ($q) => $q->whereDefault());
    }

    /**
     * @return self
     */
    public function whereDefault(): self
    {
        return $this->where($this->addTable('code'), config('app.locale'));
    }
}
