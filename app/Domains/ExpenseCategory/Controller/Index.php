<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Controller;

use Illuminate\Http\Response;
use App\Domains\ExpenseCategory\Controller\Service\Index as ControllerService;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('expense-category-index.meta-title'));

        return $this->page('expense-category.index', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }
}
