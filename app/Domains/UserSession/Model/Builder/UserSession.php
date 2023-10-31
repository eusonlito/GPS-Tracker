<?php declare(strict_types=1);

namespace App\Domains\UserSession\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserFail\Model\UserFail as UserFailModel;
use App\Domains\UserFail\Model\Builder\UserFail as UserFailBuilder;

class UserSession extends BuilderAbstract
{
    /**
     * @param string $auth
     *
     * @return self
     */
    public function byAuth(string $auth): self
    {
        return $this->where('auth', $auth);
    }

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
            return $q->where('auth', $user->email)->orWhere('user_id', $user->id);
        });
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('created_at', 'DESC');
    }

    /**
     * @return self
     */
    public function unionUserFail(): self
    {
        return $this->selectRaw('`auth`, `ip`, TRUE AS `success`, `created_at`, `user_id`')
            ->union($this->unionUserFailQuery());
    }

    /**
     * @return \App\Domains\UserFail\Model\Builder\UserFail
     */
    public function unionUserFailQuery(): UserFailBuilder
    {
        return UserFailModel::query()
            ->selectRaw('`text` AS `auth`, `ip`, FALSE AS `success`, `created_at`, `user_id`');
    }

    /**
     * @param \App\Domains\User\Model\User $user
     *
     * @return self
     */
    public function unionUserFailByUser(UserModel $user): self
    {
        return $this->selectRaw('`auth`, `ip`, TRUE AS `success`, `created_at`, `user_id`')
            ->union($this->unionUserFailQueryByUser($user));
    }

    /**
     * @param \App\Domains\User\Model\User $user
     *
     * @return \App\Domains\UserFail\Model\Builder\UserFail
     */
    public function unionUserFailQueryByUser(UserModel $user): UserFailBuilder
    {
        return UserFailModel::query()
            ->selectRaw('`text` AS `auth`, `ip`, FALSE AS `success`, `created_at`, `user_id`')
            ->byUser($user);
    }
}
