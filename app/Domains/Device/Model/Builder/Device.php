<?php declare(strict_types=1);

namespace App\Domains\Device\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Device extends BuilderAbstract
{
    /**
     * @param string $serial
     *
     * @return self
     */
    public function bySerial(string $serial): self
    {
        return $this->where('serial', $serial);
    }

    /**
     * @return self
     */
    public function withTimezone(): self
    {
        return $this->with('timezone');
    }
}
