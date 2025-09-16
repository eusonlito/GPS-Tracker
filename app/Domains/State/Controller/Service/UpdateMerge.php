<?php declare(strict_types=1);

namespace App\Domains\State\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\State\Model\Collection\State as Collection;
use App\Domains\State\Model\State as Model;

class UpdateMerge extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\State\Model\State $row
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
     * @return \App\Domains\State\Model\Collection\State
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->byIdNot($this->row->id)
                ->withCountry()
                ->list()
                ->get()
        );
    }
}
