<?php declare(strict_types=1);

namespace App\Domains\Expense\Controller\Service;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\File\Model\Collection\File as FileCollection;
use App\Domains\File\Model\File as FileModel;
use App\Domains\Expense\Model\Expense as Model;
use App\Domains\ExpenseCategory\Model\Collection\ExpenseCategory as ExpenseCategoryCollection;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as ExpenseCategoryModel;

class Update extends CreateUpdateAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     * @param \App\Domains\Expense\Model\Expense $row
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth, protected Model $row)
    {
        $this->request();
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCreateUpdate() + [
            'row' => $this->row,
            'related' => $this->row->isRelated(),
            'files' => $this->files(),
        ];
    }

    /**
     * @return \App\Domains\ExpenseCategory\Model\Collection\ExpenseCategory
     */
    protected function categories(): ExpenseCategoryCollection
    {
        if ($this->row->isRelated()) {
            return ExpenseCategoryModel::query()
                ->byId($this->row->expense_category_id)
                ->get();
        }

        return parent::categories();
    }

    /**
     * @return \App\Domains\File\Model\Collection\File
     */
    protected function files(): FileCollection
    {
        return FileModel::query()
            ->byRelated('expense', $this->row->id)
            ->list()
            ->get();
    }
}
