<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
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
        $this->requestMergeWithRow([
            'user_id' => $this->user(false)->id,
        ], $this->previous());
    }

    /**
     * @return \App\Domains\Refuel\Model\Refuel
     */
    protected function previous(): Model
    {
        return Model::query()
            ->selectOnly('distance_total', 'price')
            ->byUserId($this->user(false)->id)
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
