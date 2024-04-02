<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Exception\AuthFailed;
use App\Domains\User\Model\User as Model;

class AuthApi extends ActionAbstract
{
    /**
     * @return \App\Domains\User\Model\User
     */
    public function handle(): Model
    {
        $this->data();
        $this->check();
        $this->row();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataApiKey();
        $this->dataApiHash();
        $this->dataApiPrefix();
    }

    /**
     * @return void
     */
    protected function dataApiKey(): void
    {
        $this->data['api_key'] = strval($this->request->header('Authorization'));
        $this->data['api_key'] = preg_replace('/^\s*bearer\s+/i', '', $this->data['api_key']);
    }

    /**
     * @return void
     */
    protected function dataApiHash(): void
    {
        $this->data['api_key_hash'] = hash('sha256', $this->data['api_key']);
    }

    /**
     * @return void
     */
    protected function dataApiPrefix(): void
    {
        $this->data['api_key_prefix'] = explode('-', $this->data['api_key'], 2)[0];
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkApiKey();
        $this->checkIp();
    }

    /**
     * @return void
     */
    protected function checkApiKey(): void
    {
        if (helper()->uuidIsValid($this->data['api_key']) === false) {
            $this->fail();
        }
    }

    /**
     * @return void
     */
    protected function checkIp(): void
    {
        $this->factory('IpLock')->action()->check();
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = Model::query()
            ->byApiKey($this->data['api_key_hash'])
            ->byApiKeyPrefix($this->data['api_key_prefix'])
            ->whereApiKeyEnabled()
            ->enabled()
            ->firstOr(fn () => $this->fail());
    }

    /**
     * @throws \App\Domains\User\Exception\AuthFailed
     *
     * @return void
     */
    protected function fail(): void
    {
        $this->factory('UserFail')->action($this->failData())->create();

        throw new AuthFailed(__('user-auth-api.error.auth-fail'));
    }

    /**
     * @return array
     */
    protected function failData(): array
    {
        return [
            'type' => 'user-auth-api',
            'text' => $this->data['api_key'],
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
            'auth' => $this->row->email,
            'ip' => $this->request->ip(),
            'user_id' => $this->row->id,
        ];
    }
}
