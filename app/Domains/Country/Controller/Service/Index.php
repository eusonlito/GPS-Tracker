<?php declare(strict_types=1);

namespace App\Domains\Country\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Country\Model\Collection\Country as Collection;
use App\Domains\Country\Model\Country as Model;

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
     * @return \App\Domains\Country\Model\Collection\Country
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->list()
                ->get()
        );
    }
}
