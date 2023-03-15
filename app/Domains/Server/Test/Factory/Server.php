<?php declare(strict_types=1);

namespace App\Domains\Server\Test\Factory;

use App\Domains\SharedApp\Test\Factory\FactoryAbstract;
use App\Domains\Server\Model\Server as Model;

class Server extends FactoryAbstract
{
    /**
     * @var class-string<\App\Domains\Server\Model\Server>
     */
    protected $model = Model::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        return [
            'port' => rand(8000, 9000),
            'protocol' => 'h02',

            'debug' => false,
            'enabled' => true,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
    }
}
