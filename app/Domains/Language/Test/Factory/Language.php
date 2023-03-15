<?php declare(strict_types=1);

namespace App\Domains\Language\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
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
            'name' => ($name = $this->faker->name),
            'code' => str_slug($name),
            'locale' => $this->faker->name(),

            'default' => true,
            'enabled' => true,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
