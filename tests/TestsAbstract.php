<?php declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestsAbstract extends TestCase
{
    use RefreshDatabase;

    /**
     * @param bool $admin = true
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function authUserAdmin(bool $admin = true): Authenticatable
    {
        return $this->authUser(['admin' => $admin]);
    }

    /**
     * @param array $data = []
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function authUser(array $data = []): Authenticatable
    {
        $user = $this->user();
        $user->fill($data);
        $user->save();

        $this->auth($user);

        return $user;
    }
}
