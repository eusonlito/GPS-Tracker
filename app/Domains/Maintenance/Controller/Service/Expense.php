<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use stdClass;
use App\Domains\Maintenance\Model\Maintenance as MaintenanceModel;
use App\Domains\Refuel\Model\Refuel as RefuelModel;

class Expense extends ControllerAbstract
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
            'date_min' => $this->dateMin(),
            'list' => $this->list(),
            'stats' => $this->stats(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        return $this->cache(function () {
            return $this->listMaintenance()
                ->concat($this->listRefuel())
                ->sortByDesc('date_at')
                ->values();
        });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function listMaintenance(): Collection
    {
        return MaintenanceModel::query()
            ->whenUserId($this->user()?->id)
            ->whenVehicleId((int)$this->request->input('vehicle_id'))
            ->whenDateAtBetween($this->request->input('start_at'), $this->request->input('end_at'))
            ->withSimple('user')
            ->withSimple('vehicle')
            ->list()
            ->get()
            ->map($this->listMaintenanceRow(...))
            ->toBase();
    }

    /**
     * @param \App\Domains\Maintenance\Model\Maintenance $row
     *
     * @return \stdClass
     */
    protected function listMaintenanceRow(MaintenanceModel $row): stdClass
    {
        return (object)[
            'type' => 'maintenance',
            'id' => $row->id,
            'date_at' => $row->date_at,
            'name' => $row->name,
            'workshop' => $row->workshop,
            'distance' => (float)$row->distance,
            'amount' => (float)$row->amount,
            'quantity' => null,
            'user' => $row->user,
            'vehicle' => $row->vehicle,
            'vehicle_id' => $row->vehicle_id,
            'route' => route('maintenance.update', $row->id),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function listRefuel(): Collection
    {
        return RefuelModel::query()
            ->whenUserId($this->user()?->id)
            ->whenVehicleId((int)$this->request->input('vehicle_id'))
            ->whenDateAtBetween($this->request->input('start_at'), $this->request->input('end_at'))
            ->withSimple('user')
            ->withSimple('vehicle')
            ->list()
            ->get()
            ->map($this->listRefuelRow(...))
            ->toBase();
    }

    /**
     * @param \App\Domains\Refuel\Model\Refuel $row
     *
     * @return \stdClass
     */
    protected function listRefuelRow(RefuelModel $row): stdClass
    {
        return (object)[
            'type' => 'refuel',
            'id' => $row->id,
            'date_at' => $row->date_at,
            'name' => null,
            'workshop' => null,
            'distance' => (float)$row->distance_total,
            'amount' => (float)$row->total,
            'quantity' => (float)$row->quantity,
            'user' => $row->user,
            'vehicle' => $row->vehicle,
            'vehicle_id' => $row->vehicle_id,
            'route' => route('refuel.update', $row->id),
        ];
    }

    /**
     * @return ?\stdClass
     */
    protected function stats(): ?stdClass
    {
        if ($this->list()->isEmpty()) {
            return null;
        }

        $chronological = $this->list()->sortBy('date_at')->values();
        $first = $chronological->first();
        $last = $chronological->last();

        $maintenance_amount = $this->list()->where('type', 'maintenance')->sum('amount');
        $refuel_amount = $this->list()->where('type', 'refuel')->sum('amount');
        $total = $maintenance_amount + $refuel_amount;
        $period = $this->statsPeriod($first->date_at, $last->date_at);
        $distance = $this->statsDistance($chronological);

        return (object)[
            'maintenance_count' => $this->list()->where('type', 'maintenance')->count(),
            'maintenance_amount' => $maintenance_amount,
            'refuel_count' => $this->list()->where('type', 'refuel')->count(),
            'refuel_amount' => $refuel_amount,
            'refuel_quantity' => $this->list()->where('type', 'refuel')->sum('quantity'),
            'total' => $total,
            'distance_start' => $distance['start'],
            'distance_end' => $distance['end'],
            'distance' => $distance['total'],
            'start_at' => $period['start_at'],
            'end_at' => $period['end_at'],
            'days' => $period['days'],
            'amount_per_distance' => (($distance['total'] !== null) && ($distance['total'] > 0)) ? round($total / $distance['total'], 4) : null,
            'amount_per_day' => round($total / $period['days'], 2),
            'amount_per_month' => round($total / $period['days'] * 30, 2),
            'maintenance_amount_per_distance' => (($distance['total'] !== null) && ($distance['total'] > 0)) ? round($maintenance_amount / $distance['total'], 4) : null,
            'refuel_amount_per_distance' => (($distance['total'] !== null) && ($distance['total'] > 0)) ? round($refuel_amount / $distance['total'], 4) : null,
        ];
    }

    /**
     * @param \Illuminate\Support\Collection $chronological
     *
     * @return array
     */
    protected function statsDistance(Collection $chronological): array
    {
        if ($chronological->pluck('vehicle_id')->unique()->count() !== 1) {
            return [
                'start' => null,
                'end' => null,
                'total' => null,
            ];
        }

        $start = $chronological->first()->distance;
        $end = $chronological->last()->distance;

        return [
            'start' => $start,
            'end' => $end,
            'total' => $end - $start,
        ];
    }

    /**
     * @param string $first_date_at
     * @param string $last_date_at
     *
     * @return array
     */
    protected function statsPeriod(string $first_date_at, string $last_date_at): array
    {
        $start_at = $this->request->input('start_at') ?: substr($first_date_at, 0, 10);
        $end_at = $this->request->input('end_at') ?: substr($last_date_at, 0, 10);

        $days = (int)((strtotime($end_at) - strtotime($start_at)) / 86400) + 1;

        if ($days < 1) {
            throw new \UnexpectedValueException(__('maintenance-expense.error.days'));
        }

        return [
            'start_at' => $start_at,
            'end_at' => $end_at,
            'days' => $days,
        ];
    }

    /**
     * @return ?string
     */
    protected function dateMin(): ?string
    {
        return $this->cache(function () {
            $maintenance = MaintenanceModel::query()
                ->whenUserId($this->user()?->id)
                ->orderByDateAtAsc()
                ->rawValue('DATE(`date_at`)');

            $refuel = RefuelModel::query()
                ->whenUserId($this->user()?->id)
                ->orderByDateAtAsc()
                ->rawValue('DATE(`date_at`)');

            if (($maintenance === null) && ($refuel === null)) {
                return null;
            }

            if ($maintenance === null) {
                return $refuel;
            }

            if ($refuel === null) {
                return $maintenance;
            }

            return min($maintenance, $refuel);
        });
    }
}
