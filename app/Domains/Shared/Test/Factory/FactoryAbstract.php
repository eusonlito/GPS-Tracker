<?php declare(strict_types=1);

namespace App\Domains\Shared\Test\Factory;

use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domains\User\Model\User as UserModel;

abstract class FactoryAbstract extends Factory
{
    /**
     * @var string
     */
    protected $model;

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
        return $this->firstOrFactory(UserModel::class);
    }
}
