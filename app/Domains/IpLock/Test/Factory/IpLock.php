<?php declare(strict_types=1);

namespace App\Domains\IpLock\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\IpLock\Model\IpLock as Model;

class IpLock extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\IpLock\Model\IpLock>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'ip' => $this->faker->ip,

            'end_at' => date('Y-m-d H:i:s', strtotime('+10 minutes')),

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
