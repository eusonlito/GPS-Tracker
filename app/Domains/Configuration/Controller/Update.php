<?php declare(strict_types=1);

namespace App\Domains\Configuration\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Configuration\Service\Controller\Update as ControllerService;

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

        $this->requestMergeWithRow();

        $this->meta('title', __('configuration-update.meta-title', ['title' => $this->row->key]));

        return $this->page('configuration.update', $this->data());
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

        $this->sessionMessage('success', __('configuration-update.success'));

        return redirect()->route('configuration.update', $this->row->id);
    }
}
