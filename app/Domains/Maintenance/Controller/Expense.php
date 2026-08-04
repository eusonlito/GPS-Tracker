<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Controller;

use Illuminate\Http\Response;
use App\Domains\Maintenance\Controller\Service\Expense as ControllerService;

class Expense extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('maintenance-expense.meta-title'));

        return $this->page('maintenance.expense', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
