<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;
use App\Domains\MaintenanceItem\Model\Collection\MaintenanceItem as Collection;

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
        ];
    }

    /**
     * @return \App\Domains\MaintenanceItem\Model\Collection\Maintenance
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->byUserId($this->auth->id)
                ->withMaintenancesCount()
                ->orderByMaintenancesCount()
                ->list()
                ->get()
        );
    }
}
