<?php declare(strict_types=1);

namespace App\Domains\Shared\Service\Controller;

use Illuminate\Http\Request;
use App\Domains\Core\Traits\Factory;
use App\Domains\Device\Model\Device as Model;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Trip\Model\Collection\Trip as TripCollection;

class Device extends ControllerAbstract
{
    use Factory;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Domains\Device\Model\Device $row
     *
     * @return self
     */
    public function __construct(Request $request, protected Model $row)
    {
        $this->request = $request;
        $this->setUser();
    }

    /**
     * @return void
     */
    public function setUser(): void
    {
        $this->factory('User', $this->row->user)->action()->set();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'row' => $this->row,
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
        return $this->cache[__FUNCTION__] ??= TripModel::query()
            ->byDeviceId($this->row->id)
            ->whereShared()
            ->whereSharedPublic()
            ->list()
            ->get();
    }

    /**
     * @return bool
     */
    protected function sharedAvailable(): bool
    {
        return $this->row->shared_public
            && app('configuration')->bool('shared_enabled');
    }

    /**
     * @return string
     */
    protected function sharedUrl(): string
    {
        return route('shared.index', app('configuration')->string('shared_slug'));
    }
}
