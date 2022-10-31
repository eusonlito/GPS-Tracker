<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Language\Model\Language as LanguageModel;

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

        $this->meta('title', $this->row->name);

        return $this->page('user.update', [
            'row' => $this->row,
            'languages' => LanguageModel::list()->get(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(): RedirectResponse
    {
        $this->row = $this->action()->update();

        $this->sessionMessage('success', __('user-update.success'));

        return redirect()->route('user.update', $this->row->id);
    }
}
