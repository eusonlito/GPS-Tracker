<?php declare(strict_types=1);

namespace App\Domains\Language\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class Language extends BuilderAbstract
{
    /**
     * @param string $locale
     *
     * @return self
     */
    public function byLocale(string $locale): self
    {
        return $this->where('locale', $locale);
    }

    /**
     * @param string $code
     *
     * @return self
     */
    public function byLocaleCode(string $code): self
    {
        return $this->whereLike('locale', $code.'%');
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderByRaw('IF (`locale` = ?, TRUE, FALSE) DESC', config('app.locale'))
            ->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function selectSession(): self
    {
        return $this->select('id', 'name', 'locale');
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
        return $this->where($this->addTable('locale'), config('app.locale'));
    }
}
