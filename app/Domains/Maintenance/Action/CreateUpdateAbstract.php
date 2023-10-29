<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Model\Maintenance as Model;
use App\Domains\Vehicle\Model\Vehicle as VehicleModel;
use App\Domains\File\Action\Traits\RelatedCreateUpdate as FileRelatedCreateUpdate;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    use FileRelatedCreateUpdate;

    /**
     * @var \App\Domains\Vehicle\Model\Vehicle
     */
    protected VehicleModel $vehicle;

    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\Maintenance\Model\Maintenance
     */
    public function handle(): Model
    {
        $this->vehicle();
        $this->save();
        $this->files();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function vehicle(): void
    {
        $this->vehicle = VehicleModel::query()
            ->byId($this->data['vehicle_id'])
            ->byUserOrAdmin($this->auth)
            ->firstOrFail();
    }
}
