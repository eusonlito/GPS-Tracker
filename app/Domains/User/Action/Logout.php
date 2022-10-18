<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use Illuminate\Support\Facades\Auth;

class Logout extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->logout();
        $this->session();
    }

    /**
     * @return void
     */
    protected function logout(): void
    {
        Auth::logout();
    }

    /**
     * @return void
     */
    protected function session(): void
    {
        $this->request->session()->flush();
    }
}
