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
     * @param bool $admin_mode = true
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function authUserAdmin(bool $admin = true, bool $admin_mode = true): Authenticatable
    {
        return $this->authUser([
            'admin' => $admin,
            'admin_mode' => $admin_mode,
        ]);
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
