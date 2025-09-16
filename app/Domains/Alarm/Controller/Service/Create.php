<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;

class Create extends CreateUpdateAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->request();
        $this->typeManager();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCommon();
    }

    /**
     * @return ?string
     */
    protected function type(): ?string
    {
        return $this->typeManager->selected($this->request->input('type'));
    }
}
