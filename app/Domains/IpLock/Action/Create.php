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
        if ($this->isWhiteList()) {
            return null;
        }

        $this->save();

        return $this->row;
    }

    /**
     * @return bool
     */
    protected function isWhiteList(): bool
    {
        return in_array($this->request->ip(), config('auth.lock.whitelist'));
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->current()->updateOrCreate(
            ['ip' => $this->request->ip()],
            ['end_at' => $this->endAt()],
        );
    }

    /**
     * @return string
     */
    protected function endAt(): string
    {
        return date('c', strtotime('+'.(int)config('auth.lock.check').' seconds'));
    }
}
