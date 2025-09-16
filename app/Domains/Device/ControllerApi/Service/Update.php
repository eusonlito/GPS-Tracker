<?php declare(strict_types=1);

namespace App\Domains\Device\ControllerApi\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Device\Model\Device as Model;

class Update extends ControllerApiAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Device\Model\Device $row
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
        return $this->dataDefault()
            + $this->dataRow();
    }

    /**
     * @return array
     */
    protected function dataDefault(): array
    {
        return $this->request->input();
    }

    /**
     * @return array
     */
    protected function dataRow(): array
    {
        return $this->row->toArray();
    }
}
