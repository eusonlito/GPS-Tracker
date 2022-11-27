<?php declare(strict_types=1);

namespace App\Domains\Alarm\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Domains\Alarm\Service\Type\Manager as TypeManager;
use App\Domains\Position\Model\Position as PositionModel;

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

        $typeService = TypeManager::new();

        $this->meta('title', __('alarm-create.meta-title'));

        return $this->page('alarm.create', [
            'types' => $typeService->titles(),
            'type' => $typeService->selected($this->request->input('type')),
            'position' => PositionModel::query()->byUserId($this->auth->id)->orderByDateUtcAtDesc()->first(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function create(): RedirectResponse
    {
        $this->row = $this->action()->create();

        $this->sessionMessage('success', __('alarm-create.success'));

        return redirect()->route('alarm.update', $this->row->id);
    }
}
