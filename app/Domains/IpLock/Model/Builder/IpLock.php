<?php declare(strict_types=1);

namespace App\Domains\IpLock\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class IpLock extends BuilderAbstract
{
    /**
     * @param string $ip
     *
     * @return self
     */
    public function byIp(string $ip): self
    {
        return $this->where('ip', $ip);
    }

    /**
     * @return self
     */
    public function current(): self
    {
        return $this->where(fn ($q) => $q->where('end_at', '>=', date('Y-m-d H:i:s'))->orWhereNull('end_at'));
    }
}
