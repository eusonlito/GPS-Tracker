<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Collection\Device as DeviceCollection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Trip\Model\Collection\Trip as Collection;
use App\Domains\Trip\Model\Trip as Model;
use App\Domains\Vehicle\Model\Collection\Vehicle as VehicleCollection;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;

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

        if (is_null($start_at) || preg_match(static::DATE_REGEXP, $start_at) === 0) {
            $this->request->merge(['start_at' => date('Y-m-d', strtotime('-30 days'))]);
        }
    }

    /**
     * @return void
     */
    protected function filtersDatesEndAt(): void
    {
        $end_at = $this->request->input('end_at');

        if (is_null($end_at) || preg_match(static::DATE_REGEXP, $end_at) === 0) {
            $this->request->merge(['end_at' => '']);
        }
    }

    /**
     * @return void
     */
    protected function filtersIds(): void
    {
        $this->request->merge([
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
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'devices' => $this->devices(),
            'devices_multiple' => $this->devicesMultiple(),
            'device' => $this->device(),
            'date_min' => $this->dateMin(),
            'starts_ends' => $this->startsEnds(),
            'shared' => $this->shared(),
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function vehicles(): VehicleCollection
    {
        return $this->cache[__FUNCTION__] ??= VehicleModel::query()
            ->byUserId($this->auth->id)
            ->list()
            ->get();
    }

    /**
     * @return bool
     */
    protected function vehiclesMultiple(): bool
    {
        return $this->vehicles()->count() > 1;
    }

    /**
     * @return \App\Domains\Vehicle\Model\Vehicle
     */
    protected function vehicle(): VehicleModel
    {
        return $this->cache[__FUNCTION__] ??= $this->vehicles()->firstWhere('id', $this->request->input('vehicle_id'))
            ?: $this->vehicles()->last();
    }

    /**
     * @return \App\Domains\Device\Model\Collection\Device
     */
    protected function devices(): DeviceCollection
    {
        return $this->cache[__FUNCTION__] ??= $this->vehicle()
            ->devices()
            ->list()
            ->get();
    }

    /**
     * @return bool
     */
    protected function devicesMultiple(): bool
    {
        return $this->devices()->count() > 1;
    }

    /**
     * @return ?\App\Domains\Device\Model\Device
     */
    protected function device(): ?DeviceModel
    {
        return $this->cache[__FUNCTION__] ??= $this->devices()->firstWhere('id', $this->request->input('device_id'));
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
     * @return ?\App\Domains\Trip\Model\Collection\Trip
     */
    protected function list(): ?Collection
    {
        return $this->cache[__FUNCTION__] ??= Model::query()
            ->selectSimple()
            ->byVehicleId($this->vehicle()->id)
            ->whenDeviceId($this->device()->id ?? null)
            ->whenStartUtcAtDateBeforeAfter($this->request->input('end_at'), $this->request->input('start_at'))
            ->whenShared($this->listWhenShared())
            ->withDevice()
            ->withVehicle()
            ->list()
            ->get();
    }

    /**
     * @return ?bool
     */
    protected function listWhenShared(): ?bool
    {
        return match ($shared = $this->request->input('shared')) {
            '1', '0' => boolval($shared),
            default => null,
        };
    }
}
