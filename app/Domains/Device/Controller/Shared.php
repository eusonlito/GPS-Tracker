<?php declare(strict_types=1);

namespace App\Domains\Device\Controller;

use Illuminate\Http\Response;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Domains\Trip\Model\Collection\Trip as TripCollection;

class Shared extends ControllerAbstract
{
    /**
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $code): Response
    {
        $this->rowShared($code);

        $this->meta('title', __('device-shared.meta-title', ['title' => $this->row->name]));

        return $this->page('device.shared', [
            'trips' => $this->trips(),
        ]);
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function trips(): TripCollection
    {
        return TripModel::query()
            ->whereShared()
            ->list()
            ->get();
    }
}
