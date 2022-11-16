<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

use stdClass;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Domains\Device\Model\Device as DeviceModel;
use App\Domains\Refuel\Model\Refuel as Model;

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
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'list' => $this->list(),
            'devices' => $this->devices(),
            'devices_multiple' => ($this->devices()->count() > 1),
            'years' => $this->years(),
            'months' => $this->months(),
            'totals' => $this->totals(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        return $this->cache[__FUNCTION__] ??= Model::query()
            ->list()
            ->byUserId($this->auth->id)
            ->whenDeviceId((int)$this->request->input('device_id'))
            ->whenYear((int)$this->request->input('year'))
            ->whenMonth((int)$this->request->input('month'))
            ->withDevice()
            ->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function devices(): Collection
    {
        return $this->cache[__FUNCTION__] ??= DeviceModel::query()
            ->byUserId($this->auth->id)
            ->list()
            ->get();
    }

    /**
     * @return array
     */
    protected function years(): array
    {
        $first = Model::query()->byUserId($this->auth->id)->orderByDateAtAsc()->rawValue('YEAR(`date_at`)');
        $last = Model::query()->byUserId($this->auth->id)->orderByDateAtDesc()->rawValue('YEAR(`date_at`)');

        return $first ? range($first, $last) : [];
    }

    /**
     * @return array
     */
    protected function months(): array
    {
        return helper()->months();
    }

    /**
     * @return ?\stdClass
     */
    protected function totals(): ?stdClass
    {
        if ($this->list()->isEmpty()) {
            return null;
        }

        $totals = $this->list()->reduce(fn ($carry, $row) => $this->totalsRow($carry, $row), $this->totalsCarry());
        $totals->price = round($totals->price / $totals->count, 3);

        return $totals;
    }

    /**
     * @return \stdClass
     */
    protected function totalsCarry(): stdClass
    {
        return (object)[
            'count' => 0,
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
        $carry->count++;

        $carry->distance += $row->distance;
        $carry->quantity += $row->quantity;
        $carry->price += $row->price;
        $carry->total += $row->total;

        return $carry;
    }
}
