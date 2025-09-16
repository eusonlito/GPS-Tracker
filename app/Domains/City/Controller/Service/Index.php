<?php declare(strict_types=1);

namespace App\Domains\City\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\City\Model\City as Model;
use App\Domains\City\Model\Collection\City as Collection;

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
     * @return \App\Domains\City\Model\Collection\City
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->list()
                ->withState()
                ->withCountry()
                ->get()
        );
    }
}
