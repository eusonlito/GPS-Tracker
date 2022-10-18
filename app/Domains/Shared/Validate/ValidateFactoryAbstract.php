<?php declare(strict_types=1);

namespace App\Domains\Shared\Validate;

use BadMethodCallException;
use ReflectionClass;

abstract class ValidateFactoryAbstract
{
    /**
     * @var array
     */
    protected array $data;

    /**
     * @param array $data
     *
     * @return self
     */
    final public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $class
     *
     * @return array
     */
    final protected function handle(string $class): array
    {
        return (new $class($this->data))->handle();
    }

    /**
     * @param string $name
     * @param array $arguments
     *
     * @return array
     */
    final public function __call(string $name, array $arguments): array
    {
        $class = (new ReflectionClass($this))->getNamespaceName().'\\'.ucfirst($name);

        if (class_exists($class) === false) {
            throw new BadMethodCallException();
        }

        return $this->handle($class);
    }
}
