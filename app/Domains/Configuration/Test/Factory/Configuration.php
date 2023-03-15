<?php declare(strict_types=1);

namespace App\Domains\Configuration\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\Configuration\Model\Configuration as Model;

class Configuration extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Configuration\Model\Configuration>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'key' => uniqid(),
            'value' => 1,
            'description' => 'Configuration Test',

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
