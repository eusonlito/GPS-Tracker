<?php declare(strict_types=1);

namespace App\Domains\Shared\Test\Factory;

use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;

abstract class FactoryAbstract extends Factory
{
    /**
     * @var class-string<\App\Domains\Shared\Model\ModelAbstract>
     */
    protected $model;

    /**
     * @return string
     */
    abstract protected function getUserClass(): string;

    /**
     * @param string $class
     *
     * @return \Closure
     */
    protected function firstOrFactory(string $class): Closure
    {
        return static fn () => $class::first() ?: $class::factory();
    }

    /**
     * @return \Closure
     */
    protected function userFirstOrFactory(): Closure
    {
        return $this->firstOrFactory($this->getUserClass());
    }
}
