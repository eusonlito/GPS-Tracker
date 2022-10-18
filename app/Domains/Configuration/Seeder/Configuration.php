<?php declare(strict_types=1);

namespace App\Domains\Configuration\Seeder;

use App\Domains\Configuration\Model\Configuration as Model;
use App\Domains\Shared\Seeder\SeederAbstract;

class Configuration extends SeederAbstract
{
    /**
     * @return void
     */
    public function run()
    {
        $this->insertWithoutDuplicates(Model::class, $this->json('configuration'), 'key');
    }
}
