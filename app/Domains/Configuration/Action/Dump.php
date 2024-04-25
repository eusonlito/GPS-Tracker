<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

use App\Domains\Configuration\Model\Configuration as Model;

class Dump extends ActionAbstract
{
    /**
     * @return mixed
     */
    public function handle(): mixed
    {
        if ($this->data['config']) {
            return $this->config();
        }

        if ($this->data['server']) {
            return $this->server();
        }

        return $this->database();
    }

    /**
     * @return mixed
     */
    protected function config(): mixed
    {
        return $this->data['only']
            ? $this->configOnly()
            : $this->configAll();
    }

    /**
     * @return mixed
     */
    protected function configOnly(): mixed
    {
        return config($this->data['only']);
    }

    /**
     * @return array
     */
    protected function configAll(): array
    {
        $values = config()->all();

        ksort($values);

        return $values;
    }

    /**
     * @return mixed
     */
    protected function server(): mixed
    {
        return $this->data['only']
            ? $this->serverOnly()
            : $this->serverAll();
    }

    /**
     * @return mixed
     */
    protected function serverOnly(): mixed
    {
        return env($this->data['only']) ?? null;
    }

    /**
     * @return array
     */
    protected function serverAll(): array
    {
        $env = $_ENV;

        ksort($env);

        return $env;
    }

    /**
     * @return array|string|null
     */
    protected function database(): array|string|null
    {
        return $this->data['only']
            ? $this->databaseOnly()
            : $this->databaseAll();
    }

    /**
     * @return ?string
     */
    protected function databaseOnly(): ?string
    {
        return Model::query()->byKey($this->data['only'])->value('value');
    }

    /**
     * @return array
     */
    protected function databaseAll(): array
    {
        return Model::query()->list()->get()->toArray();
    }
}
