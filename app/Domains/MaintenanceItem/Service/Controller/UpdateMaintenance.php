<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;
use App\Domains\Maintenance\Model\MaintenanceMaintenanceItem as MaintenanceMaintenanceItemModel;
use App\Domains\Maintenance\Model\Collection\MaintenanceMaintenanceItem as MaintenanceMaintenanceItemCollection;

class UpdateMaintenance extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\MaintenanceItem\Model\MaintenanceItem $row
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
            'maintenancesPivot' => $this->maintenancesPivot(),
            'total' => $this->total(),
        ];
    }

    /**
     * @return \App\Domains\Maintenance\Model\Collection\MaintenanceMaintenanceItem
     */
    protected function maintenancesPivot(): MaintenanceMaintenanceItemCollection
    {
        return $this->cache(
            fn () => MaintenanceMaintenanceItemModel::query()
                ->byMaintenanceItemId($this->row->id)
                ->withMaintenanceWithVehicle()
                ->orderByLast()
                ->get()
        );
    }

    /**
     * @return array
     */
    protected function total(): array
    {
        $maintenancesPivot = $this->maintenancesPivot();

        return [
            'quantity' => $maintenancesPivot->sum('quantity'),
            'amount_gross' => $maintenancesPivot->sum('amount_gross'),
            'amount_net' => $maintenancesPivot->sum('amount_net'),
            'subtotal' => $maintenancesPivot->sum('subtotal'),
            'tax_amount' => $maintenancesPivot->sum('tax_amount'),
            'total' => $maintenancesPivot->sum('total'),
        ];
    }
}
