<?php declare(strict_types=1);

namespace App\Domains\Refuel\Model\Builder;

use App\Domains\City\Model\City as CityModel;
use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class Refuel extends BuilderAbstract
{
    /**
     * @param int $city_id
     *
     * @return self
     */
    public function byCityId(int $city_id): self
    {
        return $this->where('city_id', $city_id);
    }

    /**
     * @param array $city_ids
     *
     * @return self
     */
    public function byCityIds(array $city_ids): self
    {
        return $this->whereIntegerInRaw('city_id', $city_ids);
    }

    /**
     * @param int $country_id
     *
     * @return self
     */
    public function byCountryId(int $country_id): self
    {
        return $this->whereIn('city_id', CityModel::query()->selectOnly('id')->byCountryId($country_id));
    }

    /**
     * @param array $country_ids
     *
     * @return self
     */
    public function byCountryIds(array $country_ids): self
    {
        return $this->whereIn('city_id', CityModel::query()->selectOnly('id')->byCountryIds($country_ids));
    }

    /**
     * @param string $date_at
     *
     * @return self
     */
    public function byDateAtAfter(string $date_at): self
    {
        return $this->whereDate('date_at', '>=', $date_at);
    }

    /**
     * @param string $date_at
     *
     * @return self
     */
    public function byDateAtBefore(string $date_at): self
    {
        return $this->whereDate('date_at', '<=', $date_at);
    }

    /**
     * @param int $state_id
     *
     * @return self
     */
    public function byStateId(int $state_id): self
    {
        return $this->whereIn('city_id', CityModel::query()->selectOnly('id')->byStateId($state_id));
    }

    /**
     * @param array $state_ids
     *
     * @return self
     */
    public function byStateIds(array $state_ids): self
    {
        return $this->whereIn('city_id', CityModel::query()->selectOnly('id')->byStateIds($state_ids));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderByDateAtDesc();
    }

    /**
     * @return self
     */
    public function orderByDateAtDesc(): self
    {
        return $this->orderBy('date_at', 'DESC');
    }

    /**
     * @return self
     */
    public function orderByDateAtAsc(): self
    {
        return $this->orderBy('date_at', 'ASC');
    }

    /**
     * @param ?int $city_id
     *
     * @return self
     */
    public function whenCityId(?int $city_id): self
    {
        return $this->when($city_id, fn ($q) => $q->byCityId($city_id));
    }

    /**
     * @param ?int $city_id
     * @param ?int $state_id
     * @param ?int $country_id
     *
     * @return self
     */
    public function whenCityStateCountryId(?int $city_id, ?int $state_id, ?int $country_id): self
    {
        if ($city_id) {
            return $this->byCityId($city_id);
        }

        if ($state_id) {
            return $this->byStateId($state_id);
        }

        if ($country_id) {
            return $this->byCountryId($country_id);
        }

        return $this;
    }

    /**
     * @param ?int $country_id
     *
     * @return self
     */
    public function whenCountryId(?int $country_id): self
    {
        return $this->when($country_id, fn ($q) => $q->byCountryId($country_id));
    }

    /**
     * @param ?string $before_date_at
     * @param ?string $after_date_at
     *
     * @return self
     */
    public function whenDateAtBetween(?string $before_date_at, ?string $after_date_at): self
    {
        return $this->whenDateAtAfter($before_date_at)->whenDateAtBefore($after_date_at);
    }

    /**
     * @param ?string $date_at
     *
     * @return self
     */
    public function whenDateAtAfter(?string $date_at): self
    {
        return $this->when($date_at, fn ($q) => $q->byDateAtAfter($date_at));
    }

    /**
     * @param ?string $date_at
     *
     * @return self
     */
    public function whenDateAtBefore(?string $date_at): self
    {
        return $this->when($date_at, fn ($q) => $q->byDateAtBefore($date_at));
    }

    /**
     * @param ?int $state_id
     *
     * @return self
     */
    public function whenStateId(?int $state_id): self
    {
        return $this->when($state_id, fn ($q) => $q->byStateId($state_id));
    }

    /**
     * @param ?int $user_id
     * @param ?int $vehicle_id
     * @param ?string $before_date_at
     * @param ?string $after_date_at
     *
     * @return self
     */
    public function whenUserIdVehicleIdDateAtBetween(?int $user_id, ?int $vehicle_id, ?string $before_date_at, ?string $after_date_at): self
    {
        return $this->whenUserId($user_id)
            ->whenVehicleId($vehicle_id)
            ->whenDateAtBetween($before_date_at, $after_date_at);
    }

    /**
     * @return self
     */
    public function withCity(): self
    {
        return $this->with('city');
    }

    /**
     * @return self
     */
    public function withCityState(): self
    {
        return $this->with(['city' => fn ($q) => $q->withState()]);
    }

    /**
     * @return self
     */
    public function withVehicle(): self
    {
        return $this->with('vehicle');
    }

    /**
     * @return self
     */
    public function withWhereHasPosition(): self
    {
        return $this->withWhereHas('position', fn ($q) => $q->withCityState());
    }

    /**
     * @return self
     */
    public function withoutCity(): self
    {
        return $this->whereNull('city_id');
    }
}
