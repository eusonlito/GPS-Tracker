<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Trip\Model\Trip as Model;
use App\Domains\Trip\Model\Collection\Trip as Collection;

class UpdateMerge extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Trip\Model\Trip $row
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
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Trip\Model\Collection\Trip
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->selectSimple()
                ->byUserId($this->row->user_id)
                ->list()
                ->get()
        );
    }
}
