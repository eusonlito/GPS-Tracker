<?php declare(strict_types=1);

namespace App\Domains\Profile\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Language\Model\Language as LanguageModel;

class Update extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        $this->load();

        if ($response = $this->actionPost('update')) {
            return $response;
        }

        $this->requestMergeWithRow();

        $this->meta('title', __('profile-update.meta-title'));

        return $this->page('profile.update', [
            'languages' => LanguageModel::query()->list()->get(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function update(): RedirectResponse
    {
        $this->action()->update();

        $this->sessionMessage('success', __('profile-update.success'));

        return redirect()->route('profile.update');
    }
}
