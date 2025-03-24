<?php declare(strict_types=1);

namespace App\Domains\User\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;

class User extends BuilderAbstract
{
    /**
     * @param string $api_key
     *
     * @return self
     */
    public function byApiKey(string $api_key): self
    {
        return $this->where('api_key', $api_key);
    }

    /**
     * @param string $api_key_prefix
     *
     * @return self
     */
    public function byApiKeyPrefix(string $api_key_prefix): self
    {
        return $this->where('api_key_prefix', $api_key_prefix);
    }

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
        return $this->select('id', 'name');
    }

    /**
     * @return self
     */
    public function listSimple(): self
    {
        return $this->selectRelated()->orderBy('name', 'ASC');
    }

    /**
     * @param bool $api_key_enabled = true
     *
     * @return self
     */
    public function whereApiKeyEnabled(bool $api_key_enabled = true): self
    {
        return $this->where('api_key_enabled', $api_key_enabled);
    }
}
