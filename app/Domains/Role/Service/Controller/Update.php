<?php declare(strict_types=1);

namespace App\Domains\Alarm\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Alarm\Model\Alarm as Model;

class Update extends CreateUpdateAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Alarm\Model\Alarm $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
        $this->request();
        $this->typeManager();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCommon() + [
            'row' => $this->row,
        ];
    }

    /**
     * @return string
     */
    protected function type(): string
    {
        return $this->row->type;
    }
}
