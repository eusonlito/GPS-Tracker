<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

use stdClass;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\Refuel\Model\Collection\Refuel as Collection;

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
        $this->filtersIds();
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
    protected function filtersIds(): void
    {
        $this->request->merge([
            'user_id' => $this->auth->preference('user_id', $this->request->input('user_id')),
            'vehicle_id' => $this->auth->preference('vehicle_id', $this->request->input('vehicle_id')),
        ]);
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
            'totals' => $this->totals(),
        ];
    }

    /**
     * @return \App\Domains\Refuel\Model\Collection\Refuel
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId((int)$this->request->input('vehicle_id'))
                ->whenDateAtDateBeforeAfter($this->request->input('end_at'), $this->request->input('start_at'))
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

    /**
     * @return ?\stdClass
     */
    protected function totals(): ?stdClass
    {
        if ($this->list()->isEmpty()) {
            return null;
        }

        $totals = $this->list()->reduce($this->totalsRow(...), $this->totalsCarry());
        $totals->price = round($totals->total / $totals->quantity, 3);

        return $totals;
    }

    /**
     * @return \stdClass
     */
    protected function totalsCarry(): stdClass
    {
        return (object)[
            'distance' => 0,
            'quantity' => 0,
            'price' => 0,
            'total' => 0,
        ];
    }

    /**
     * @param \stdClass $carry
     * @param \App\Domains\Refuel\Model\Refuel $row
     *
     * @return \stdClass
     */
    protected function totalsRow(stdClass $carry, Model $row): stdClass
    {
        $carry->distance += $row->distance;
        $carry->quantity += $row->quantity;
        $carry->price += $row->price;
        $carry->total += $row->total;

        return $carry;
    }
}
