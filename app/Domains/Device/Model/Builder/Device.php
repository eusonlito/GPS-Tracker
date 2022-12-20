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
