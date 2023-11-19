<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\IpLock\Model\IpLock as Model;

abstract class CreateUpdateAbstract extends ActionAbstract
{
    /**
     * @return void
     */
    abstract protected function save(): void;

    /**
     * @return \App\Domains\IpLock\Model\IpLock
     */
    public function handle(): Model
    {
        $this->check();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkIp();
    }

    /**
     * @return void
     */
    protected function checkIp(): void
    {
        $this->checkIpSame();
        $this->checkIpExists();
    }

    /**
     * @return void
     */
    protected function checkIpSame(): void
    {
        if ($this->data['ip'] === $this->request->ip()) {
            $this->exceptionValidator(__('ip-lock-create.error.same'));
        }
    }

    /**
     * @return void
     */
    protected function checkIpExists(): void
    {
        if ($this->checkIpExistsResult()) {
            $this->exceptionValidator(__('ip-lock-create.error.exists'));
        }
    }

    /**
     * @return bool
     */
    protected function checkIpExistsResult(): bool
    {
        return Model::query()
            ->byIdNot($this->row->id ?? 0)
            ->byIp($this->data['ip'])
            ->exists();
    }
}
