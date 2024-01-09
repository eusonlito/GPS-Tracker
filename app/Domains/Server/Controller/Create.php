<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Services\Protocol\ProtocolFactory;

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

        $this->requestMergeWithRow();

        $this->meta('title', __('server-create.meta-title'));

        return $this->page('server.create', [
            'protocols' => array_keys(ProtocolFactory::list()),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('server-create.success'));

        return redirect()->route('server.update', $this->row->id);
    }
}
