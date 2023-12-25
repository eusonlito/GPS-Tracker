<?php declare(strict_types=1);

namespace App\Domains\City\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\City\Model\City as Model;
use App\Domains\City\Model\Collection\City as Collection;

class UpdateMerge extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\City\Model\City $row
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
     * @return \App\Domains\City\Model\Collection\City
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->byIdNot($this->row->id)
                ->withState()
                ->withCountry()
                ->list()
                ->get()
        );
    }
}
