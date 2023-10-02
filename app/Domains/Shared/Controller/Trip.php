<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Illuminate\Http\Response;
use App\Domains\Position\Model\Collection\Position as PositionCollection;
use App\Domains\Trip\Model\Trip as TripModel;
use App\Exceptions\NotFoundException;

class Trip extends ControllerAbstract
{
    /**
     * @var \App\Domains\Trip\Model\Trip
     */
    protected TripModel $trip;

    /**
     * @param string $code
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(string $code): Response
    {
        $this->trip($code);

        $this->meta('title', __('shared-trip.meta-title', ['title' => $this->trip->name]));

        return $this->page('shared.trip', [
            'trip' => $this->trip,
            'device' => $this->trip->device,
            'positions' => $this->positions(),
            'stats' => $this->trip->stats,
        ]);
    }

    /**
     * @param string $code
     *
     * @return void
     */
    protected function trip(string $code): void
    {
        $this->trip = TripModel::query()
            ->byCode($code)
            ->whereShared()
            ->firstOr(static function () {
                throw new NotFoundException(__('shared-trip.error.not-found'));
            });

        $this->factory('User', $this->trip->user)->action()->set();
    }

    /**
     * @return \App\Domains\Position\Model\Collection\Position
     */
    protected function positions(): PositionCollection
    {
        return $this->trip->positions()
            ->withCity()
            ->list()
            ->get();
    }
}
