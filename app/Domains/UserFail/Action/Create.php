<?php declare(strict_types=1);

namespace App\Domains\UserFail\Action;

use App\Domains\User\Model\User as UserModel;
use App\Domains\UserFail\Model\UserFail as Model;

class Create extends ActionAbstract
{
    /**
     * @return \App\Domains\UserFail\Model\UserFail
     */
    public function handle(): Model
    {
        $this->data();
        $this->save();

        return $this->row;
    }

    /**
     * @return void
     */
    protected function data(): void
    {
        $this->dataIp();
        $this->dataUserId();
    }

    /**
     * @return void
     */
    protected function dataIp(): void
    {
        $this->data['ip'] ??= $this->request->ip();
    }

    /**
     * @return void
     */
    protected function dataUserId(): void
    {
        if ($this->data['user_id'] === null) {
            return;
        }

        $this->data['user_id'] = UserModel::query()
            ->byId($this->data['user_id'])
            ->valueOrFail('id');
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->saveRow();
        $this->saveIpLock();
    }

    /**
     * @return void
     */
    protected function saveRow(): void
    {
        $this->row = Model::query()->create([
            'type' => $this->data['type'],
            'text' => $this->data['text'],
            'ip' => $this->data['ip'],
            'user_id' => $this->data['user_id'],
        ])->fresh();
    }

    /**
     * @return void
     */
    protected function saveIpLock(): void
    {
        if ($this->saveIpLockCurrent() === false) {
            return;
        }

        $action = $this->factory('IpLock')->action($this->saveIpLockData());

        $action->lock();
        $action->check();
    }

    /**
     * @return array
     */
    protected function saveIpLockData(): array
    {
        return [
            'ip' => $this->data['ip'],
        ];
    }

    /**
     * @return bool
     */
    protected function saveIpLockCurrent(): bool
    {
        return $this->saveIpLockCount() > (int)config('auth.lock.allowed');
    }

    /**
     * @return int
     */
    protected function saveIpLockCount(): int
    {
        return Model::query()
            ->byIp($this->data['ip'])
            ->byCreatedAtAfter($this->saveIpLockCountDate())
            ->count();
    }

    /**
     * @return string
     */
    protected function saveIpLockCountDate(): string
    {
        return date('Y-m-d H:i:s', strtotime('-'.(int)config('auth.lock.check').' seconds'));
    }
}
