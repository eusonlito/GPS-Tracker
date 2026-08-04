<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Fractal;

use App\Domains\Core\Fractal\FractalAbstract;
use App\Domains\ExpenseCategory\Model\ExpenseCategory as Model;

class FractalFactory extends FractalAbstract
{
    /**
     * @param \App\Domains\ExpenseCategory\Model\ExpenseCategory $row
     *
     * @return array
     */
    protected function simple(Model $row): array
    {
        return [
            'id' => $row->id,
            'name' => $row->name,
        ];
    }
}
