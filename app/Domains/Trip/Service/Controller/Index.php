<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Trip\Model\Collection\Trip as Collection;
use App\Domains\Trip\Model\Trip as Model;

class Index extends ControllerAbstract
{
    /**
     * @const string
     */
    protected const DATE_REGEXP = '/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/';

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->filters();
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->filtersDates();
        $this->filtersIds();
    }

    /**
     * @return void
     */
    protected function filtersDates(): void
    {
        $this->filtersDatesStartAt();
        $this->filtersDatesEndAt();
    }

    /**
     * @return void
     */
    protected function filtersDatesStartAt(): void
    {
        $start_at = $this->request->input('start_at');

        if ($start_at === '') {
            return;
        }

        if (is_null($start_at) || (preg_match(static::DATE_REGEXP, $start_at) === 0)) {
            $this->request->merge(['start_at' => date('Y-m-d', strtotime('-30 days'))]);
        }
    }

    /**
     * @return void
     */
    protected function filtersDatesEndAt(): void
    {
        $end_at = $this->request->input('end_at');

        if (is_null($end_at) || (preg_match(static::DATE_REGEXP, $end_at) === 0)) {
            $this->request->merge(['end_at' => '']);
        }
    }

    /**
     * @return void
     */
    protected function filtersIds(): void
    {
        $this->request->merge([
            'user_id' => $this->auth->preference('user_id', $this->request->input('user_id')),
            'vehicle_id' => $this->auth->preference('vehicle_id', $this->request->input('vehicle_id')),
            'device_id' => $this->auth->preference('device_id', $this->request->input('device_id')),
        ]);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'users' => $this->users(),
            'users_multiple' => $this->usersMultiple(),
            'user' => $this->user(),
            'user_empty' => $this->userEmpty(),
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'vehicle_empty' => $this->vehicleEmpty(),
            'devices' => $this->devices(),
            'devices_multiple' => $this->devicesMultiple(),
            'device' => $this->device(),
            'device_empty' => $this->deviceEmpty(),
            'date_min' => $this->dateMin(),
            'starts_ends' => $this->startsEnds(),
            'shared' => $this->shared(),
            'shared_public' => $this->sharedPublic(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return ?string
     */
    protected function dateMin(): ?string
    {
        if ($device = $this->device()) {
            $ids = [$device->id];
        } else {
            $ids = $this->devices()->pluck('id')->all();
        }

        return Model::query()
            ->byDeviceIds($ids)
            ->orderByStartAtAsc()
            ->rawValue('DATE(`start_utc_at`)');
    }

    /**
     * @return array
     */
    protected function startsEnds(): array
    {
        return [
            'start' => __('trip-index.start'),
            'end' => __('trip-index.end'),
        ];
    }

    /**
     * @return array
     */
    protected function shared(): array
    {
        return [
            '' => __('trip-index.shared-all'),
            '1' => __('trip-index.shared-yes'),
            '0' => __('trip-index.shared-no'),
        ];
    }

    /**
     * @return array
     */
    protected function sharedPublic(): array
    {
        return [
            '' => __('trip-index.shared_public-all'),
            '1' => __('trip-index.shared_public-yes'),
            '0' => __('trip-index.shared_public-no'),
        ];
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->selectSimple()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId($this->vehicle()?->id)
                ->whenDeviceId($this->device()?->id)
                ->whenStartUtcAtDateBeforeAfter($this->request->input('end_at'), $this->request->input('start_at'))
                ->whenShared($this->requestBool('shared'))
                ->whenSharedPublic($this->requestBool('shared_public'))
                ->withSimple('device')
                ->withSimple('user')
                ->withSimple('vehicle')
                ->list()
                ->get()
        );
    }
}
