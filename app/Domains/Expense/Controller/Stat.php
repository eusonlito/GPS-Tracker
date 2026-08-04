<?php declare(strict_types=1);

namespace App\Domains\Expense\Controller;

use Illuminate\Http\Response;
use App\Domains\Expense\Controller\Service\Stat as ControllerService;

class Stat extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('expense-stat.meta-title'));

        return $this->page('expense.stat', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
