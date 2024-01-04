<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Position\Model\Position as PositionModel;
use App\Domains\Refuel\Model\Refuel as Model;

class Create extends CreateUpdateAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->request();
    }

    /**
     * @return void
     */
    protected function request(): void
    {
        $this->requestMergeWithRow($this->requestMergeWithRowData(), $this->previous());
    }

    /**
     * @return array
     */
    protected function requestMergeWithRowData(): array
    {
        return $this->requestMergeWithRowUserId()
            + $this->requestMergeWithRowLocation();
    }

    /**
     * @return array
     */
    protected function requestMergeWithRowUserId(): array
    {
        return ['user_id' => $this->user()->id];
    }

    /**
     * @return array
     */
    protected function requestMergeWithRowLocation(): array
    {
        return PositionModel::query()
            ->selectOnly('latitude', 'longitude')
            ->byUserId($this->user()->id)
            ->orderByLast()
            ->firstOrNew()
            ->only('latitude', 'longitude');
    }

    /**
     * @return \App\Domains\Refuel\Model\Refuel
     */
    protected function previous(): Model
    {
        return Model::query()
            ->selectOnly('distance_total', 'price')
            ->byUserId($this->user()->id)
            ->orderByLast()
            ->firstOrNew();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCreateUpdate();
    }
}
