<?php declare(strict_types=1);

namespace App\Domains\State\Model\Builder;

use App\Domains\City\Model\City as CityModel;
use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class State extends BuilderAbstract
{
    /**
     * @param int $country_id
     *
     * @return self
     */
    public function byCountryId(int $country_id): self
    {
        return $this->where('country_id', $country_id);
    }

    /**
     * @param int $user_id
     * @param ?int $days
     *
     * @return self
     */
    public function byUserIdAndDays(int $user_id, ?int $days): self
    {
        return $this->whereIn('id', CityModel::select('state_id')->byUserIdAndDays($user_id, $days));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('name', 'ASC');
    }
}
