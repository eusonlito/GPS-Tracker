<?php declare(strict_types=1);

namespace App\Domains\Country\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Country\Model\Country as Model;
use App\Domains\Country\Model\Collection\Country as Collection;

class UpdateMerge extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Country\Model\Country $row
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
     * @return \App\Domains\Country\Model\Collection\Country
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->byIdNot($this->row->id)
                ->list()
                ->get()
        );
    }
}
