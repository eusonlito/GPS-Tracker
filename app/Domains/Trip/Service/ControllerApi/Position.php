<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\ControllerApi;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Trip\Model\Trip as Model;

class Position extends ControllerApiAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Trip\Model\Trip $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return PositionModel::query()
            ->byTripId($this->row->id)
            ->withCityCountryState()
            ->list()
            ->get()
            ->all();
    }
}
