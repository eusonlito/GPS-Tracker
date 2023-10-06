<?php declare(strict_types=1);

namespace App\Domains\Shared\Service\Controller;

use Illuminate\Http\Request;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Trip\Model\Collection\Trip as TripCollection;

class Device extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Domains\Device\Model\Device $device
     *
     * @return self
     */
    public function __construct(Request $request, protected DeviceModel $device)
    {
        $this->request = $request;
        $this->setUser();
    }

    /**
     * @return void
     */
    public function setUser(): void
    {
        $this->factory('User', $this->device->user)->action()->set();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'device' => $this->device,
            'trips' => $this->trips(),
            'shared_available' => $this->sharedAvailable(),
            'shared_url' => $this->sharedUrl(),
        ];
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function trips(): TripCollection
    {
        return $this->cache(
            fn () => TripModel::query()
                ->byDeviceId($this->device->id)
                ->whereSharedPublic()
                ->list()
                ->get()
        );
    }

    /**
     * @return bool
     */
    protected function sharedAvailable(): bool
    {
        return $this->device->shared_public
            && app('configuration')->bool('shared_enabled');
    }
}
