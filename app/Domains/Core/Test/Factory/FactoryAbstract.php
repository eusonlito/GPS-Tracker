<?php declare(strict_types=1);

namespace App\Domains\Core\Test\Factory;

use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domains\User\Model\User as UserModel;

abstract class FactoryAbstract extends Factory
{
    /**
     * @var class-string<\App\Domains\Core\Model\ModelAbstract|\App\Domains\Core\Model\PivotAbstract>
     */
    protected $model;

    /**
     * @return string
     */
    protected function getUserClass(): string
    {
        return UserModel::class;
    }

    /**
     * @param string $class
     *
     * @return \Closure
     */
    protected function firstOrFactory(string $class): Closure
    {
        return static fn () => $class::orderBy('id', 'ASC')->first() ?: $class::factory();
    }

    /**
     * @param string $class
     *
     * @return \Closure
     */
    protected function lastOrFactory(string $class): Closure
    {
        return static fn () => $class::orderBy('id', 'DESC')->first() ?: $class::factory();
    }

    /**
     * @return \Closure
     */
    protected function userFirstOrFactory(): Closure
    {
        return $this->firstOrFactory($this->getUserClass());
    }
}
