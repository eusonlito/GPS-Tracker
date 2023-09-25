<?php declare(strict_types=1);

namespace App\Domains\Device\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Device extends BuilderAbstract
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
     * @param string $serial
     *
     * @return self
     */
    public function bySerial(string $serial): self
    {
        return $this->where('serial', $serial);
    }

    /**
     * @param ?bool $shared
     *
     * @return self
     */
    public function whenShared(?bool $shared): self
    {
        return $this->when(is_bool($shared), static fn ($q) => $q->whereShared($shared));
    }

    /**
     * @param bool $shared = true
     *
     * @return self
     */
    public function whereShared(bool $shared = true): self
    {
        return $this->where('shared', $shared);
    }

    /**
     * @return self
     */
    public function withMessagesCount(): self
    {
        return $this->withCount('messages');
    }

    /**
     * @return self
     */
    public function withMessagesPendingCount(): self
    {
        return $this->withCount(['messages as messages_pending_count' => static fn ($q) => $q->whereResponseAt()]);
    }

    /**
     * @return self
     */
    public function withVehicle(): self
    {
        return $this->with(['vehicle' => static fn ($q) => $q->withTimezone()]);
    }
}
