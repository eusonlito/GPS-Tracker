<?php declare(strict_types=1);

namespace App\Domains\Configuration\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class Configuration extends BuilderAbstract
{
    /**
     * @param string $key
     *
     * @return self
     */
    public function byKey(string $key): self
    {
        return $this->where('key', $key);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('key', 'ASC');
    }
}
