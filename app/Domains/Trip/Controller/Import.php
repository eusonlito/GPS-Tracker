<?php declare(strict_types=1);

namespace App\Domains\Trip\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Trip\Service\Controller\Import as ControllerService;

class Import extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($response = $this->actionPost('import')) {
            return $response;
        }

        $this->meta('title', __('trip-import.meta-title'));

        return $this->page('trip.import', $this->data());
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
    protected function import(): RedirectResponse
    {
        $this->row = $this->action()->import();

        $this->sessionMessage('success', __('trip-import.success'));

        return redirect()->route('trip.update', $this->row->id);
    }
}
