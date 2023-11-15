<?php declare(strict_types=1);

namespace App\Domains\Timezone\Seeder;

use Illuminate\Contracts\Database\Query\Expression;
use App\Domains\Core\Seeder\SeederAbstract;
use App\Domains\Timezone\Model\Timezone as Model;

class Timezone extends SeederAbstract
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->insertWithoutDuplicates(Model::class, $this->map($this->json('timezone')), 'zone');
    }

    /**
     * @param array $list
     *
     * @return array
     */
    protected function map(array $list): array
    {
        $geojson = $this->geojson();

        return array_map(static fn ($row) => ['geojson' => $geojson] + $row, $list);
    }

    /**
     * @return \Illuminate\Contracts\Database\Query\Expression
     */
    protected function geojson(): Expression
    {
        return Model::db()->raw(Model::emptyGeoJSON());
    }
}
