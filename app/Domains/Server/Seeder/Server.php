<?php declare(strict_types=1);

namespace App\Domains\Server\Seeder;

use App\Domains\Core\Seeder\SeederAbstract;
use App\Domains\Server\Model\Server as Model;

class Server extends SeederAbstract
{
    /**
     * @return void
     */
    public function run(): void
    {
        if (Model::query()->count()) {
            return;
        }

        $this->insertWithoutDuplicates(Model::class, 'port', $this->json('server'));
    }
}
