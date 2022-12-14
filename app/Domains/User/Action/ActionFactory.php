<?php declare(strict_types=1);

namespace App\Domains\User\Action;

use App\Domains\Shared\Action\ActionFactoryAbstract;
use App\Domains\User\Model\User as Model;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\User\Model\User
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\User\Model\User
     */
    public function authCredentials(): Model
    {
        return $this->actionHandle(AuthCredentials::class, $this->validate()->authCredentials());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function authModel(): Model
    {
        return $this->actionHandle(AuthModel::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function create(): Model
    {
        return $this->actionHandleTransaction(Create::class, $this->validate()->create());
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->actionHandle(Delete::class);
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        $this->actionHandle(Logout::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function profile(): Model
    {
        return $this->actionHandleTransaction(Profile::class, $this->validate()->profile());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function profileTelegram(): Model
    {
        return $this->actionHandleTransaction(ProfileTelegram::class, $this->validate()->profileTelegram());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function profileTelegramChatId(): Model
    {
        return $this->actionHandleTransaction(ProfileTelegramChatId::class);
    }

    /**
     * @return void
     */
    public function request(): void
    {
        $this->actionHandle(Request::class);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function update(): Model
    {
        return $this->actionHandleTransaction(Update::class, $this->validate()->update());
    }
}
