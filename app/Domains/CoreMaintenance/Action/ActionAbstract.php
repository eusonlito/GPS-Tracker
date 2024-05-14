<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

use InvalidArgumentException;
use ReflectionClass;
use UnexpectedValueException;
use App\Domains\CoreApp\Action\ActionAbstract as ActionAbstractCore;

abstract class ActionAbstract extends ActionAbstractCore
{
    /**
     * @var array
     */
    protected array $config;

    /**
     * @param string $key
     *
     * @return mixed
     */
    protected function config(string $key): mixed
    {
        $this->config ??= $this->configLoad();

        if (array_key_exists($key, $this->config) === false) {
            throw new InvalidArgumentException(sprintf('Invalid config key %s', $key));
        }

        return $this->config[$key];
    }

    /**
     * @return array
     */
    protected function configLoad(): array
    {
        $name = snake_case((new ReflectionClass($this))->getShortName(), '-');
        $config = config('maintenance.'.$name);

        if (is_array($config) === false) {
            throw new UnexpectedValueException(sprintf('Invalid Config %s', $name));
        }

        return $config;
    }
}
