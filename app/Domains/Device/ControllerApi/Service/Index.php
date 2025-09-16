<?php declare(strict_types=1);

namespace App\Domains\Device\ControllerApi\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Device as Model;

class Index extends ControllerApiAbstract
{
    /**
     * @var bool
     */
    protected bool $userEmpty = true;

    /**
     * @var bool
     */
    protected bool $vehicleEmpty = true;

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
     * @return array
     */
    public function data(): array
    {
        return Model::query()
            ->byUserOrManager($this->auth)
            ->whenUserId($this->requestInteger('user_id'))
            ->whenVehicleId($this->requestInteger('vehicle_id'))
            ->withSimple('user')
            ->withSimple('vehicle')
            ->list()
            ->get()
            ->all();
    }
}
