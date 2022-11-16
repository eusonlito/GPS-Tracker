<?php declare(strict_types=1);

namespace App\Domains\City\Model\Builder;

use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;
use App\Domains\State\Model\State as StateModel;

class City extends BuilderAbstract
{
    /**
     * @param int $country_id
     *
     * @return self
     */
    public function byCountryId(int $country_id): self
    {
        return $this->whereIn('state_id', StateModel::query()->select('id')->byCountryId($country_id));
    }

    /**
     * @param int $state_id
     *
     * @return self
     */
    public function byStateId(int $state_id): self
    {
        return $this->where('state_id', $state_id);
    }

    /**
     * @param int $distance
     *
     * @return self
     */
    public function byDistanceMax(int $distance): self
    {
        return $this->where('distance', '<=', $distance);
    }

    /**
     * @param int $user_id
     * @param ?int $days
     *
     * @return self
     */
    public function byUserIdAndDays(int $user_id, ?int $days): self
    {
        return $this->whereIn('id', PositionModel::query()->select('city_id')->byUserId($user_id)->whenLastDays($days));
    }

    /**
     * @param int $user_id
     * @param ?int $days
     * @param ?string $start_end
     *
     * @return self
     */
    public function byUserIdDaysAndStartEnd(int $user_id, ?int $days, ?string $start_end): self
    {
        return $this->whereIn('id', PositionModel::query()->select('city_id')->byUserId($user_id)->whenLastDays($days)->whenStartEnd($start_end));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->select('id', 'name', 'state_id')->orderBy('name', 'ASC');
    }

    /**
     * @return self
     */
    public function orderByDistance(): self
    {
        return $this->orderBy('distance', 'ASC');
    }

    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function selectDistance(float $latitude, float $longitude): self
    {
        return $this->selectRaw(sprintf('*, ST_Distance_Sphere(`point`, ST_SRID(POINT(%f, %f), 4326)) `distance`', $latitude, $longitude));
    }

    /**
     * @return self
     */
    public function selectPointAsLatitudeLongitude(): self
    {
        return $this->selectRaw('
            `id`, `name`, `created_at`, `updated_at`, `state_id`,
            ROUND(ST_X(`point`), 5) AS `longitude`, ROUND(ST_Y(`point`), 5) AS `latitude`,
        ');
    }

    /**
     * @return self
     */
    public function withState(): self
    {
        return $this->with('state');
    }
}
