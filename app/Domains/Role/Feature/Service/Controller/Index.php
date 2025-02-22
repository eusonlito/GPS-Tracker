<?php declare(strict_types=1);

namespace App\Domains\Role\Feature\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Role\Feature\Model\Collection\Feature as Collection;
use App\Domains\Role\Feature\Model\Feature as Model;

class Index extends ControllerAbstract
{
    /**
     * @var bool
     */
    protected bool $userEmpty = true;

    /**
     * @var bool
     */
    protected bool $vehicleEmpty = true;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->data();
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
     * @return \App\Domains\Role\Feature\Model\Collection\Feature
     */

    public function list(): Collection
    {
        return new Collection(Model::query()->get()->all());
    }
}
