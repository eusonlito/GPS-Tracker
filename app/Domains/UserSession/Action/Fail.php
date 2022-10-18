<?php declare(strict_types=1);

namespace App\Domains\UserSession\Action;

use App\Domains\UserSession\Model\UserSession as Model;

class Fail extends ActionAbstract
{
    /**
     * @var string
     */
    protected string $ip;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->ip = $this->request->ip();

        $this->save();

        if ($this->shouldBeLocked()) {
            $this->lock();
        }
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        Model::insert([
            'auth' => $this->data['auth'],
            'ip' => $this->ip,
            'success' => false,
        ]);
    }

    /**
     * @return bool
     */
    protected function shouldBeLocked(): bool
    {
        return $this->count() > (int)config('auth.lock.allowed');
    }

    /**
     * @return int
     */
    protected function count(): int
    {
        return Model::where('success', false)
            ->where('ip', $this->ip)
            ->where('created_at', '>=', $this->authLockCheckDate())
            ->count();
    }

    /**
     * @return string
     */
    protected function authLockCheckDate(): string
    {
        return date('c', strtotime('-'.(int)config('auth.lock.check').' seconds'));
    }

    /**
     * @return void
     */
    protected function lock(): void
    {
        $action = $this->factory('IpLock')->action();

        $action->create();
        $action->check();
    }
}
