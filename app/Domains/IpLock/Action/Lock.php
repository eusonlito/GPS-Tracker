<?php declare(strict_types=1);

namespace App\Domains\IpLock\Action;

use App\Domains\IpLock\Model\IpLock as Model;

class Lock extends ActionAbstract
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
        $this->dataEndAt();
    }

    /**
     * @return void
     */
    protected function dataEndAt(): void
    {
        $this->data['end_at'] = date(
            'Y-m-d H:i:s',
            strtotime('+'.(int)config('auth.lock.check').' seconds')
        );
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
            ['end_at' => $this->data['end_at']],
        );
    }
}
