<?php declare(strict_types=1);

namespace App\Domains\Vehicle\ControllerApi\Service;

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
        return ['timezone_id' => $this->dataCustomTimezoneId()];
    }

    /**
     * @return int
     */
    protected function dataCustomTimezoneId(): int
    {
        return $this->requestInteger('timezone_id', $this->auth->timezone_id);
    }

    /**
     * @return array
     */
    protected function dataDefault(): array
    {
        return $this->request->input();
    }
}
