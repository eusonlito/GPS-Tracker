<?php declare(strict_types=1);

namespace App\Domains\Timezone\Seeder;

use App\Domains\Timezone\Model\Timezone as Model;
use App\Domains\Shared\Seeder\SeederAbstract;

class Timezone extends SeederAbstract
{
    /**
     * @return void
     */
    public function run()
    {
        $this->insertWithoutDuplicates(Model::class, $this->json('timezone'), 'zone');
    }
}
