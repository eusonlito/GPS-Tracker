<?php declare(strict_types=1);

namespace App\Domains\Language\Test\Factory;

use App\Domains\CoreApp\Test\Factory\FactoryAbstract;
use App\Domains\Language\Model\Language as Model;

class Language extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Language\Model\Language>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => 'Language: '.($name = $this->faker->name),
            'code' => str_slug($name),
            'locale' => $this->faker->name(),

            'enabled' => true,
        ];
    }
}
