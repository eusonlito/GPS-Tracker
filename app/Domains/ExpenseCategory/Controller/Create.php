<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\ExpenseCategory\Controller\Service\Create as ControllerService;

class Create extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($response = $this->actionPost('create')) {
            return $response;
        }

        $this->meta('title', __('expense-category-create.meta-title'));

        return $this->page('expense-category.create', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth)->data();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('expense-category-create.success'));

        return redirect()->route('expense-category.update', $this->row->id);
    }
}
