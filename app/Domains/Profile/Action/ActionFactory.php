<?php declare(strict_types=1);

namespace App\Domains\Profile\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;
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
    public function update(): Model
    {
        return $this->actionHandleTransaction(Update::class, $this->validate()->update());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function updateTelegram(): Model
    {
        return $this->actionHandleTransaction(UpdateTelegram::class, $this->validate()->updateTelegram());
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    public function updateTelegramChatId(): Model
    {
        return $this->actionHandleTransaction(UpdateTelegramChatId::class);
    }
}
