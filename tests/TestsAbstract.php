<?php declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestsAbstract extends TestCase
{
    use RefreshDatabase;

    /**
     * @param ?int $id = null
     * @param bool $admin = true
     * @param bool $admin_mode = true
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function authUserAdmin(?int $id = null, bool $admin = true, bool $admin_mode = true): Authenticatable
    {
        return $this->authUser($id, [
            'admin' => $admin,
            'admin_mode' => $admin_mode,
        ]);
    }

    /**
     * @param ?int $id = null
     * @param array $data = []
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    protected function authUser(?int $id = null, array $data = []): Authenticatable
    {
        $user = $this->user($id);
        $user->fill($data);
        $user->save();

        $this->auth($user);

        return $user;
    }
}
