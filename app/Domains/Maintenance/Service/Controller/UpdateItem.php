<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\Maintenance\Model\MaintenanceMaintenanceItem as MaintenanceMaintenanceItemModel;
use App\Domains\Maintenance\Model\Collection\MaintenanceMaintenanceItem as MaintenanceMaintenanceItemCollection;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as MaintenanceItemModel;
use App\Domains\MaintenanceItem\Model\Collection\MaintenanceItem as MaintenanceItemCollection;

class UpdateItem extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Maintenance\Model\Maintenance $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'row' => $this->row,
            'items' => $this->items(),
            'itemsPivot' => $this->itemsPivot(),
            'total' => $this->total(),
        ];
    }

    /**
     * @return \App\Domains\MaintenanceItem\Model\Collection\MaintenanceItem
     */
    protected function items(): MaintenanceItemCollection
    {
        return MaintenanceItemModel::query()
            ->byUserId($this->user()->id)
            ->list()
            ->get()
            ->merge($this->itemsMerge());
    }

    /**
     * @return \App\Domains\MaintenanceItem\Model\Collection\MaintenanceItem
     */
    protected function itemsMerge(): MaintenanceItemCollection
    {
        return new MaintenanceItemCollection([
            new MaintenanceItemModel([
                'id' => 0,
                'name' => __('maintenance-update-item.add'),
            ]),
        ]);
    }

    /**
     * @return \App\Domains\Maintenance\Model\Collection\MaintenanceMaintenanceItem
     */
    protected function itemsPivot(): MaintenanceMaintenanceItemCollection
    {
        return $this->cache(
            fn () => MaintenanceMaintenanceItemModel::query()
                ->byMaintenanceId($this->row->id)
                ->list()
                ->get()
        );
    }

    /**
     * @return array
     */
    protected function total(): array
    {
        $itemsPivot = $this->itemsPivot();

        return [
            'quantity' => $itemsPivot->sum('quantity'),
            'amount_gross' => $itemsPivot->sum('amount_gross'),
            'amount_net' => $itemsPivot->sum('amount_net'),
            'subtotal' => $itemsPivot->sum('subtotal'),
            'tax_amount' => $itemsPivot->sum('tax_amount'),
            'total' => $itemsPivot->sum('total'),
        ];
    }
}
