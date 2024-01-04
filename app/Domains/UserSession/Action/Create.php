<?php declare(strict_types=1);

namespace App\Domains\UserSession\Action;

use App\Domains\User\Model\User as UserModel;
use App\Domains\UserSession\Model\UserSession as Model;

class Create extends ActionAbstract
{
    /**
     * @return \App\Domains\UserSession\Model\UserSession
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
        $this->data['user_id'] = UserModel::query()
            ->selectOnly('id')
            ->byId($this->data['user_id'])
            ->valueOrFail('id');
    }

    /**
     * @return void
     */
    protected function save(): void
    {
        $this->row = Model::query()->create([
            'auth' => $this->data['auth'],
            'ip' => $this->data['ip'],
            'user_id' => $this->data['user_id'],
        ])->fresh();
    }
}
