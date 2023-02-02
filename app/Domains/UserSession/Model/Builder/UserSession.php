<?php declare(strict_types=1);

namespace App\Domains\UserSession\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;
use App\Domains\User\Model\User as UserModel;

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
     * @param string $created_at
     *
     * @return self
     */
    public function byCreatedAtAfter(string $created_at): self
    {
        return $this->where('created_at', '>=', $created_at);
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
        return $this->orderByCreatedAtDesc();
    }

    /**
     * @param bool $success
     *
     * @return self
     */
    public function whereSuccess(bool $success = true): self
    {
        return $this->where('success', $success);
    }

    /**
     * @return self
     */
    public function withUser(): self
    {
        return $this->with('user');
    }
}
