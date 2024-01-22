<?php declare(strict_types=1);

namespace App\Domains\Trip\Service\Controller;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use App\Domains\Timezone\Model\Timezone as TimezoneModel;
use App\Domains\Timezone\Model\Collection\Timezone as TimezoneCollection;
use App\Domains\Trip\Model\Trip as Model;

class Import extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->request();
    }

    /**
     * @return void
     */
    protected function request(): void
    {
        $this->request->merge([
            'user_id' => $this->user()->id,
            'timezone_id' => $this->requestTimezoneId(),
        ]);
    }

    /**
     * @return ?int
     */
    protected function requestTimezoneId(): ?int
    {
        return $this->requestInteger('timezone_id')
            ?: $this->requestTimezoneIdLast();
    }

    /**
     * @return ?int
     */
    protected function requestTimezoneIdLast(): ?int
    {
        return Model::query()
            ->byUserId($this->user()->id)
            ->orderByLast()
            ->value('timezone_id');
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'users' => $this->users(),
            'users_multiple' => $this->usersMultiple(),
            'user' => $this->user(),
            'vehicles' => $this->vehicles(),
            'vehicles_multiple' => $this->vehiclesMultiple(),
            'vehicle' => $this->vehicle(),
            'devices' => $this->devices(),
            'devices_multiple' => $this->devicesMultiple(),
            'device' => $this->device(),
            'timezones' => $this->timezones(),
        ];
    }

    /**
     * @return \App\Domains\Timezone\Model\Collection\Timezone
     */
    protected function timezones(): TimezoneCollection
    {
        return TimezoneModel::query()
            ->list()
            ->get();
    }
}
