<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\User\Exception\AuthFailed;

class Request extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->row();
        $this->check();
        $this->set();
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = $this->request->user();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (empty($this->row)) {
            throw new AuthFailed(__('user-auth.error.empty'));
        }
    }

    /**
     * @return void
     */
    protected function set(): void
    {
        $this->factory(row: $this->row)->action()->set();
    }
}
