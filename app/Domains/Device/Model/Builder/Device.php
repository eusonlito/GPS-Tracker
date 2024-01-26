<?php declare(strict_types=1);

namespace App\Domains\Device\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\Trip\Model\Trip as TripModel;

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
     * @return self
     */
    public function listSimple(): self
    {
        return $this->select('id', 'name')->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function selectRelated(): self
    {
        return $this->selectOnly('id', 'name', 'user_id', 'vehicle_id');
    }

    /**
     * @param ?bool $finished
     *
     * @return self
     */
    public function whenTripFinished(?bool $finished): self
    {
        return $this->when(is_bool($finished), fn ($q) => $q->whereTripFinished($finished));
    }

    /**
     * @param ?bool $shared
     *
     * @return self
     */
    public function whenShared(?bool $shared): self
    {
        return $this->when(is_bool($shared), fn ($q) => $q->whereShared($shared));
    }

    /**
     * @param ?bool $shared_public
     *
     * @return self
     */
    public function whenSharedPublic(?bool $shared_public): self
    {
        return $this->when(is_bool($shared_public), fn ($q) => $q->whereSharedPublic($shared_public));
    }

    /**
     * @param bool $finished = true
     *
     * @return self
     */
    public function whereTripFinished(bool $finished = true): self
    {
        return $this->whereIn('id', TripModel::query()->selectOnly('device_id')->whereFinished($finished));
    }

    /**
     * @param bool $shared_public = true
     *
     * @return self
     */
    public function whereTripSharedPublic(bool $shared_public = true): self
    {
        return $this->whereIn('id', TripModel::query()->selectOnly('device_id')->whereSharedPublic($shared_public));
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
     * @param bool $shared_public = true
     *
     * @return self
     */
    public function whereSharedPublic(bool $shared_public = true): self
    {
        return $this->whereShared()->where('shared_public', $shared_public);
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
        return $this->withCount(['messages as messages_pending_count' => fn ($q) => $q->whereResponseAt()]);
    }

    /**
     * @return self
     */
    public function withWhereHasPositionLast(): self
    {
        return $this->withWhereHas('positionLast', fn ($q) => $q->withCityState());
    }

    /**
     * @return self
     */
    public function withTripLastShared(): self
    {
        return $this->with('tripLastShared');
    }

    /**
     * @return self
     */
    public function withTripLastSharedPublic(): self
    {
        return $this->with('tripLastSharedPublic');
    }

    /**
     * @return self
     */
    public function withVehicle(): self
    {
        return $this->with(['vehicle' => fn ($q) => $q->withTimezone()]);
    }

    /**
     * @return self
     */
    public function withWhereHasTripLastSharedPublic(): self
    {
        return $this->withWhereHas('tripLastSharedPublic');
    }
}
