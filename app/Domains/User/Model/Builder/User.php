<?php declare(strict_types=1);

namespace App\Domains\User\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class User extends BuilderAbstract
{
    /**
     * @param string $email
     *
     * @return self
     */
    public function byEmail(string $email): self
    {
        return $this->where('email', strtolower($email));
    }

    /**
     * @return self
     */
    public function selectRelated(): self
    {
        return $this->selectOnly('id', 'name');
    }

    /**
     * @return self
     */
    public function listSimple(): self
    {
        return $this->selectRelated()->orderBy('name', 'ASC');
    }
}
