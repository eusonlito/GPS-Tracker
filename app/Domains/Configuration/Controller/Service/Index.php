<?php declare(strict_types=1);

namespace App\Domains\Configuration\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Configuration\Model\Collection\Configuration as Collection;
use App\Domains\Configuration\Model\Configuration as Model;

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
     * @return \App\Domains\Configuration\Model\Collection\Configuration
     */
    protected function list(): Collection
    {
        return Model::query()
            ->list()
            ->get();
    }
}
