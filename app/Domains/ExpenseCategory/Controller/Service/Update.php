<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as Model;

class Update extends CreateUpdateAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\ExpenseCategory\Model\ExpenseCategory $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
        $this->request();
    }

    /**
     * @return void
     */
    protected function request(): void
    {
        $this->requestMergeWithRow([
            'user_id' => $this->user()->id,
            'global' => $this->row->isGlobal(),
        ]);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCreateUpdate() + [
            'row' => $this->row,
            'global' => $this->row->isGlobal(),
            'system' => $this->row->isSystem(),
        ];
    }
}
