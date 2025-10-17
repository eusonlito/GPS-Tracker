<?php declare(strict_types=1);

namespace App\Domains\Position\ControllerApi\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Domains\Position\Model\Position as Model;

class Index extends ControllerApiAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function data(): LengthAwarePaginator
    {
        return Model::query()
            ->byUserOrManager($this->auth)
            ->whenUserId($this->requestInteger('user_id'))
            ->whenVehicleId($this->requestInteger('vehicle_id'))
            ->whenDeviceId($this->requestInteger('device_id'))
            ->whenTripId($this->requestInteger('trip_id'))
            ->whenDateAtBetween($this->request->input('start_at'), $this->request->input('end_at'))
            ->listSimple()
            ->withRelations($this->requestArray('with'))
            ->paginate(min($this->requestInteger('limit', 100), 1000));
    }
}
