<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\MaintenanceItem\Model\MaintenanceItem as Model;
use App\Domains\MaintenanceItem\Model\Collection\MaintenanceItem as Collection;

class Index extends ControllerAbstract
{
    /**
     * @var bool
     */
    protected bool $userEmpty = true;

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
        $this->filtersUserId();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCore() + [
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\MaintenanceItem\Model\Collection\MaintenanceItem
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->withMaintenancesCount()
                ->withStats()
                ->withSimple('user')
                ->orderByMaintenancesCount()
                ->list()
                ->get()
        );
    }
}
