<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\IpLock\Model\IpLock as Model;

class Check extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->check();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (Model::where('ip', $this->request->ip())->current()->limit(1)->count()) {
            $this->exceptionValidator(__('ip-lock.error.locked'));
        }
    }
}
