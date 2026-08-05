<?php declare(strict_types=1);

namespace App\Domains\Expense\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use stdClass;
use App\Domains\Expense\Model\Collection\Expense as Collection;
use App\Domains\Expense\Model\Expense as Model;

class Stat extends ControllerAbstract
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
            'stats' => $this->stats(),
        ];
    }

    /**
     * @return \App\Domains\Expense\Model\Collection\Expense
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->whenVehicleId((int)$this->request->input('vehicle_id'))
                ->whenDateAtBetween($this->request->input('start_at'), $this->request->input('end_at'))
                ->withSimple('user')
                ->withSimple('vehicle')
                ->withCategory()
                ->list()
                ->get()
        );
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

        $total = $this->list()->sum('amount');
        $period = $this->statsPeriod($first->date_at, $last->date_at);
        $distance = $this->statsDistance($chronological);

        return (object)[
            'categories' => $this->statsCategories($total, $distance['total'], $period['days']),
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
        ];
    }

    /**
     * @param float $total
     * @param ?float $distance
     * @param int $days
     *
     * @return array<int, \stdClass>
     */
    protected function statsCategories(float $total, ?float $distance, int $days): array
    {
        return $this->list()
            ->groupBy('expense_category_id')
            ->map(fn ($rows) => $this->statsCategory($rows, $total, $distance, $days))
            ->sortByDesc('amount')
            ->values()
            ->all();
    }

    /**
     * @param \App\Domains\Expense\Model\Collection\Expense $rows
     * @param float $total
     * @param ?float $distance
     * @param int $days
     *
     * @return \stdClass
     */
    protected function statsCategory(Collection $rows, float $total, ?float $distance, int $days): stdClass
    {
        $amount = $rows->sum('amount');

        return (object)[
            'id' => $rows->first()->expense_category_id,
            'name' => $rows->first()->category->name,
            'count' => $rows->count(),
            'amount' => $amount,
            'percent' => ($total > 0) ? round($amount / $total * 100, 1) : 0.0,
            'amount_per_distance' => (($distance !== null) && ($distance > 0)) ? round($amount / $distance, 4) : null,
            'amount_per_day' => round($amount / $days, 2),
            'amount_per_month' => round($amount / $days * 30, 2),
        ];
    }

    /**
     * @param \App\Domains\Expense\Model\Collection\Expense $chronological
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

        $with_distance = $chronological->filter(fn ($row) => $row->distance !== null);

        if ($with_distance->isEmpty()) {
            return [
                'start' => null,
                'end' => null,
                'total' => null,
            ];
        }

        $start = (float)$with_distance->first()->distance;
        $end = (float)$with_distance->last()->distance;

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
            throw new \UnexpectedValueException(__('expense-stat.error.days'));
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
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->orderByDateAtAsc()
                ->rawValue('DATE(`date_at`)')
        );
    }
}
