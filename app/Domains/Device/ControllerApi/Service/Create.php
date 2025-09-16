<?php declare(strict_types=1);

namespace App\Domains\Device\ControllerApi\Service;

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
        return $this->dataCustom() + $this->dataDefault();
    }

    /**
     * @return array
     */
    protected function dataCustom(): array
    {
        return ['code' => helper()->uuid()];
    }

    /**
     * @return array
     */
    protected function dataDefault(): array
    {
        return $this->request->input();
    }
}
