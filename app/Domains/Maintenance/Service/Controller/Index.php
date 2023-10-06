<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\Maintenance\Model\Collection\Maintenance as Collection;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;
use App\Domains\Vehicle\Model\Collection\Vehicle as VehicleCollection;

class Index extends ControllerAbstract
{
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
     * @return array
     */
    public function data(): array
    {
        return [
            'list' => $this->list(),
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => ($this->vehicles()->count() > 1),
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
                ->list()
                ->byUserId($this->auth->id)
                ->whenSearch($this->request->input('search'))
                ->whenVehicleId((int)$this->request->input('vehicle_id'))
                ->whenDateAtDateBeforeAfter($this->request->input('end_at'), $this->request->input('start_at'))
                ->withVehicle()
                ->get()
        );
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function vehicles(): VehicleCollection
    {
        return $this->cache(
            fn () => VehicleModel::query()
                ->byUserId($this->auth->id)
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
                ->byUserId($this->auth->id)
                ->orderByDateAtAsc()
                ->rawValue('DATE(`date_at`)')
        );
    }
}
