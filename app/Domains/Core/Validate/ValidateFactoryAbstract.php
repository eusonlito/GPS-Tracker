<?php declare(strict_types=1);

namespace App\Domains\Core\Validate;

use BadMethodCallException;
use ReflectionClass;
use Illuminate\Http\Request;

abstract class ValidateFactoryAbstract
{
    /**
     * @param ?\Illuminate\Http\Request $request
     * @param array $data
     *
     * @return self
     */
    final public function __construct(protected ?Request $request, protected array $data)
    {
    }

    /**
     * @param string $class
     *
     * @return array
     */
    final protected function handle(string $class): array
    {
        return $class::new($this->request, $this->data)->handle();
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $name
     * @param array $arguments
     *
     * @return array
     */
    final public function __call(string $name, array $arguments): array
    {
        $class = (new ReflectionClass($this))->getNamespaceName().'\\'.ucfirst($name);

        if (class_exists($class) === false) {
            throw new BadMethodCallException(sprintf('Invalid Validator Method %s', $name));
        }

        return $this->handle($class);
    }
}
