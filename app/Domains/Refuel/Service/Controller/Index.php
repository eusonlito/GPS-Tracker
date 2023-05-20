<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

use stdClass;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Refuel\Model\Refuel as Model;
use App\Domains\Refuel\Model\Collection\Refuel as Collection;
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
            'totals' => $this->totals(),
        ];
    }

    /**
     * @return \App\Domains\Refuel\Model\Collection\Refuel
     */
    protected function list(): Collection
    {
        return $this->cache[__FUNCTION__] ??= Model::query()
            ->list()
            ->byUserId($this->auth->id)
            ->whenVehicleId((int)$this->request->input('vehicle_id'))
            ->whenDateAtDateBeforeAfter($this->request->input('end_at'), $this->request->input('start_at'))
            ->withVehicle()
            ->get();
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
     * @return ?string
     */
    protected function dateMin(): ?string
    {
        return Model::query()->byUserId($this->auth->id)->orderByDateAtAsc()->rawValue('DATE(`date_at`)');
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
