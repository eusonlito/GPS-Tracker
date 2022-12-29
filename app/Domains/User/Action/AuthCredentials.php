<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Domains\User\Model\User as Model;
use App\Exceptions\AuthenticationException;

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
        $this->login();
        $this->auth();
        $this->success();

        return $this->row;
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
        $this->row = Model::query()->byEmail($this->data['email'])->enabled()->firstOr(fn () => $this->fail());
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
     * @throws \App\Exceptions\AuthenticationException
     *
     * @return void
     */
    protected function fail(): void
    {
        $this->factory('UserSession')->action(['auth' => $this->data['email']])->fail();

        throw new AuthenticationException(__('user-auth-credentials.error.auth-fail'));
    }

    /**
     * @return void
     */
    protected function login(): void
    {
        Auth::login($this->row, true);
    }

    /**
     * @return void
     */
    protected function auth(): void
    {
        $this->row = $this->auth = Auth::user();
    }

    /**
     * @return void
     */
    protected function success(): void
    {
        $this->factory('UserSession')->action(['auth' => $this->data['email']])->success($this->row);
    }
}
