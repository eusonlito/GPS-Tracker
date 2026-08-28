<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\ExpenseCategory\Model\Collection\ExpenseCategory as Collection;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as Model;

class Index extends ControllerAbstract
{
    /**
     * @var bool
     */
    protected bool $userEmpty = true;

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->filters();
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->filtersUserId();
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
     * @return \App\Domains\ExpenseCategory\Model\Collection\ExpenseCategory
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserIdOrNull($this->user()?->id)
                ->withExpensesCount()
                ->withSimple('user')
                ->list()
                ->get()
        );
    }
}
