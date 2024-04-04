<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\ControllerApi;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Trip\Model\Trip as Model;

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
     * @return array
     */
    public function data(): array
    {
        return Model::query()
            ->byUserOrManager($this->auth)
            ->whenUserId($this->requestInteger('user_id'))
            ->whenVehicleId($this->requestInteger('vehicle_id'))
            ->whenDeviceId($this->requestInteger('device_id'))
            ->whenStartAtDateBetween($this->request->input('start_at'), $this->request->input('end_at'))
            ->whenShared($this->requestBool('shared', null))
            ->whenSharedPublic($this->requestBool('shared_public', null))
            ->withSimple('device')
            ->withSimple('timezone')
            ->withSimple('user')
            ->withSimple('vehicle')
            ->listSimple()
            ->get()
            ->all();
    }
}
