<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\IpLock\Exception\IpLocked as IpLockedException;
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
        if ($this->exists()) {
            throw new IpLockedException(__('ip-lock.error.locked'));
        }
    }

    /**
     * @return bool
     */
    protected function exists(): bool
    {
        return Model::query()
            ->byIp($this->data['ip'])
            ->current()
            ->exists();
    }
}
