<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
use App\Domains\Vehicle\Model\Vehicle as Model;

class UpdateDevice extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Vehicle\Model\Vehicle $row
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
        return [
            'row' => $this->row,
            'devices' => $this->devices(),
        ];
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function devices(): DeviceCollection
    {
        return $this->cache(
            fn () => DeviceModel::query()
                ->byUserId($this->user()->id)
                ->withVehicle()
                ->list()
                ->get()
        );
    }
}
