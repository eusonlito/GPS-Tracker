<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Service\ControllerApi;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Vehicle\Model\Vehicle as Model;

class Index extends ControllerApiAbstract
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
        return Model::query()
            ->byUserOrManager($this->auth)
            ->whenUserId($this->requestInteger('user_id'))
            ->withSimple('devices')
            ->withSimple('user')
            ->withSimple('timezone')
            ->list()
            ->get()
            ->all();
    }
}
