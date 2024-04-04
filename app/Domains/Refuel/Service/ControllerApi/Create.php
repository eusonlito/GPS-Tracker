<?php declare(strict_types=1);

namespace App\Domains\Refuel\Service\ControllerApi;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class Create extends ControllerApiAbstract
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
        return $this->dataDefault();
    }

    /**
     * @return array
     */
    protected function dataDefault(): array
    {
        return $this->request->input();
    }
}
