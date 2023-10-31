<?php declare(strict_types=1);

namespace App\Domains\UserFail\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\User\Model\User as UserModel;

class UserFail extends BuilderAbstract
{
    /**
     * @param string $ip
     *
     * @return self
     */
    public function byIp(string $ip): self
    {
        return $this->where('ip', $ip);
    }

    /**
     * @param \App\Domains\User\Model\User $user
     *
     * @return self
     */
    public function byUser(UserModel $user): self
    {
        return $this->orWhere(static function ($q) use ($user) {
            return $q->where('text', $user->email)->orWhere('user_id', $user->id);
        });
    }
}
