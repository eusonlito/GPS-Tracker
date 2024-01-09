<?php declare(strict_types=1);

namespace App\Domains\Server\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Services\Protocol\ProtocolFactory;

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

        if ($response = $this->actions()) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', __('server-update.meta-title', ['title' => $this->row->port.' - '.$this->row->protocol]));

        return $this->page('server.update', [
            'row' => $this->row,
            'protocols' => array_keys(ProtocolFactory::list()),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|false|null
     */
    protected function actions(): RedirectResponse|false|null
    {
        return $this->actionPost('update')
            ?: $this->actionPost('delete');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(): RedirectResponse
    {
        $this->action()->update();

        $this->sessionMessage('success', __('server-update.success'));

        return redirect()->route('server.update', $this->row->id);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function delete(): RedirectResponse
    {
        $this->action()->delete();

        $this->sessionMessage('success', __('server-update.delete-success'));

        return redirect()->route('server.index');
    }
}
