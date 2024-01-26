<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Hash;
use App\Domains\User\Exception\AuthFailed;
use App\Domains\User\Model\User as Model;

class AuthCredentials extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->checkIp();
        $this->row();
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function checkIp(): void
    {
        $this->factory('IpLock')->action($this->checkIpData())->check();
    }

    /**
     * @return array
     */
    protected function checkIpData(): array
    {
        return [
            'ip' => $this->request->ip(),
        ];
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::query()
            ->byEmail($this->data['email'])
            ->enabled()
            ->firstOr(fn () => $this->fail());
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkPassword();
    }

    /**
     * @return void
     */
    protected function checkPassword(): void
    {
        if (Hash::check($this->data['password'], $this->row->password) === false) {
            $this->fail();
        }
    }

    /**
     * @throws \App\Domains\User\Exception\AuthFailed
     *
     * @return void
     */
    protected function fail(): void
    {
        $this->factory('UserFail')->action($this->failData())->create();

        throw new AuthFailed(__('user-auth-credentials.error.auth-fail'));
    }

    /**
     * @return array
     */
    protected function failData(): array
    {
        return [
            'type' => 'user-auth-credentials',
            'text' => $this->data['email'],
            'ip' => $this->request->ip(),
            'user_id' => $this->row?->id,
        ];
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveSet();
        $this->saveAuth();
        $this->saveUserSession();
    }

    /**
     * @return void
     */
    protected function saveSet(): void
    {
        $this->factory()->action()->set();
    }

    /**
     * @return void
     */
    protected function saveAuth(): void
    {
        $this->auth = $this->row;
    }

    /**
     * @return void
     */
    protected function saveUserSession(): void
    {
        $this->factory('UserSession')->action($this->saveUserSessionData())->create();
    }

    /**
     * @return array
     */
    protected function saveUserSessionData(): array
    {
        return [
            'auth' => $this->data['email'],
            'ip' => $this->request->ip(),
            'user_id' => $this->row->id,
        ];
    }
}
