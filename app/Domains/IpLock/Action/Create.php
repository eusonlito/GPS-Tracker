<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\IpLock\Model\IpLock as Model;

class Create extends ActionAbstract
{
    /**
     * @return ?\App\Domains\IpLock\Model\IpLock
     */
    public function handle(): ?Model
    {
        $this->data();

        if ($this->isWhiteList()) {
            return null;
        }

        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataIp();
    }

    /**
     * @return void
     */
    protected function dataIp(): void
    {
        $this->data['ip'] ??= $this->request->ip();
    }

    /**
     * @return bool
     */
    protected function isWhiteList(): bool
    {
        return in_array($this->data['ip'], config('auth.lock.whitelist'));
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->current()->updateOrCreate(
            ['ip' => $this->data['ip']],
            ['end_at' => $this->endAt()],
        );
    }

    /**
     * @return string
     */
    protected function endAt(): string
    {
        return date('Y-m-d H:i:s', strtotime('+'.(int)config('auth.lock.check').' seconds'));
    }
}
