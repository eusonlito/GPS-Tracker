<?php declare(strict_types=1);

namespace App\Domains\Permissions\Feature\Service\Controller;


use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Permissions\Model\Collection\Permission as Collection;
use App\Domains\Permissions\Model\Permission as Model;

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
     * @return \App\Domains\Permissions\Model\Collection\Permission
     */
    public function list(): Collection
    {
        return new Collection(Model::query()->get()->all());
    }
}
