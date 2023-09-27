<?php declare(strict_types=1);

namespace App\Domains\Configuration\Seeder;

use App\Domains\Configuration\Model\Configuration as Model;
use App\Domains\Core\Seeder\SeederAbstract;

class Configuration extends SeederAbstract
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->insertWithoutDuplicates(Model::class, $this->json('configuration'), 'key');
    }
}
