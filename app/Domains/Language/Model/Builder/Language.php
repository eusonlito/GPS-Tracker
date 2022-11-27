<?php declare(strict_types=1);

namespace App\Domains\Language\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

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
        return $this->orderBy('name', 'ASC');
    }

    /**
     * @param ?int $id
     *
     * @return self
     */
    public function whenIdOrDefault(?int $id): self
    {
        return $this->when($id, static fn ($q) => $q->byId($id), static fn ($q) => $q->whereDefault(true));
    }

    /**
     * @param bool $default = true
     *
     * @return self
     */
    public function whereDefault(bool $default = true): self
    {
        return $this->where('default', $default);
    }
}
