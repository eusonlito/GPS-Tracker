<?php declare(strict_types=1);

namespace App\Domains\Shared\Service\Controller;

use Illuminate\Http\Request;
use App\Domains\Core\Traits\Factory;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;

class Index extends ControllerAbstract
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
        if ($row = $this->devices()->first()) {
            $this->factory('User', $row->user)->action()->set();
        }
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'devices' => $this->devices(),
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
            ->withTripLastSharedPublic()
            ->list()
            ->get()
            ->sortByDesc('withTripLastSharedPublic.id');
    }
}
