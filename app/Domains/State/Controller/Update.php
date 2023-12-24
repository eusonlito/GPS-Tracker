<?php declare(strict_types=1);

namespace App\Domains\State\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\State\Service\Controller\Update as ControllerService;

class Update extends ControllerAbstract
{
    /**
     * @param int $id
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(int $id): Response|RedirectResponse
    {
        $this->row($id);

        if ($response = $this->actionPost('update')) {
            return $response;
        }

        $this->meta('title', __('state-update.meta-title', ['title' => $this->row->name]));

        return $this->page('state.update', $this->data());
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ControllerService::new($this->request, $this->auth, $this->row)->data();
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(): RedirectResponse
    {
        $this->action()->update();

        $this->sessionMessage('success', __('state-update.success'));

        return redirect()->route('state.update', $this->row->id);
    }
}
