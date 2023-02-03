<?php declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

abstract class TestsAbstract extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function setUp(): void
    {
        $this->setUpPreload();
        $this->setUpDatabase();

        parent::setUp();
    }

    /**
     * @return void
     */
    public function setUpPreload(): void
    {
        $this->refreshApplication();
    }

    /**
     * @return void
     */
    public function setUpDatabase(): void
    {
        $database = config('database.connections.test.database');

        config(['database.connections.test.database' => null]);

        DB::statement('CREATE DATABASE IF NOT EXISTS `'.$database.'`;');

        config(['database.connections.test.database' => $database]);
    }

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
