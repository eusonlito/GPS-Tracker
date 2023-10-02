<?php declare(strict_types=1);

namespace App\Domains\Shared\Service\Controller;

use Illuminate\Http\Request;
use App\Domains\Core\Traits\Factory;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
use App\Domains\Device\Model\Device as DeviceModel;

class Map extends ControllerAbstract
{
    use Factory;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->setUser();
    }

    /**
     * @return void
     */
    public function setUser(): void
    {
        if ($device = $this->devices()->first()) {
            $this->factory('User', $device->user)->action()->set();
        }
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'devices' => $this->devices(),
            'shared_url' => $this->sharedUrl(),
            'shared_url_map' => $this->sharedUrlMap(),
        ];
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function devices(): DeviceCollection
    {
        return $this->cache[__FUNCTION__] ??= DeviceModel::query()
            ->whereShared()
            ->whereSharedPublic()
            ->withVehicle()
            ->withPositionLast()
            ->list()
            ->get()
            ->filter(static fn ($device) => $device->positionLast);
    }
}
