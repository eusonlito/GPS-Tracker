<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\Maintenance\Model\Collection\Maintenance as Collection;

class Index extends ControllerAbstract
{
    /**
     * @var bool
     */
    protected bool $userEmpty = true;

    /**
     * @var bool
     */
    protected bool $vehicleEmpty = true;

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
        $this->filterIds();
    }

    /**
     * @return void
     */
    protected function filtersDates(): void
    {
        if (preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', (string)$this->request->input('start_at')) === 0) {
            $this->request->merge(['start_at' => '']);
        }

        if (preg_match('/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/', (string)$this->request->input('end_at')) === 0) {
            $this->request->merge(['end_at' => '']);
        }
    }

    /**
     * @return void
     */
    protected function filterIds(): void
    {
        $this->filtersUserId();
        $this->filtersVehicleId();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCore() + [
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'vehicle_empty' => $this->vehicleEmpty(),
            'list' => $this->list(),
            'date_min' => $this->dateMin(),
            'total' => $this->list()->sum('amount'),
        ];
    }

    /**
     * @return \App\Domains\Maintenance\Model\Collection\Maintenance
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->whenSearch($this->request->input('search'))
                ->whenVehicleId((int)$this->request->input('vehicle_id'))
                ->whenDateAtBetween($this->request->input('start_at'), $this->request->input('end_at'))
                ->withSimple('user')
                ->withSimple('vehicle')
                ->list()
                ->get()
        );
    }

    /**
     * @return ?string
     */
    protected function dateMin(): ?string
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->orderByDateAtAsc()
                ->rawValue('DATE(`date_at`)')
        );
    }
}
