<?php declare(strict_types=1);

namespace App\Domains\Timezone\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Timezone extends BuilderAbstract
{
    /**
     * @param string $zone
     *
     * @return self
     */
    public function byZone(string $zone): self
    {
        return $this->where('zone', $zone);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('zone', 'ASC');
    }
}
