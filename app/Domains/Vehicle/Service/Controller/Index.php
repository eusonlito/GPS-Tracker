<?php declare(strict_types=1);

namespace App\Domains\Vehicle\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Vehicle\Model\Vehicle as Model;
use App\Domains\Vehicle\Model\Collection\Vehicle as Collection;

class Index extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->filters();
    }

    /**
     * @return void
     */
    protected function filters(): void
    {
        $this->request->merge([
            'user_id' => $this->auth->preference('user_id', $this->request->input('user_id')),
        ]);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return $this->dataCore() + [
            'list' => $this->list(),
        ];
    }

    /**
     * @return \App\Domains\Vehicle\Model\Collection\Vehicle
     */
    protected function list(): Collection
    {
        return $this->cache(
            fn () => Model::query()
                ->whenUserId($this->user()?->id)
                ->withAlarmsCount()
                ->withAlarmsNotificationsCount()
                ->withAlarmsNotificationsPendingCount()
                ->withTimezone()
                ->withUser()
                ->list()
                ->get()
        );
    }
}
