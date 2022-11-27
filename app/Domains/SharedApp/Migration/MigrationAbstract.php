<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Migration;

use Doctrine\DBAL\Types\Type;
use App\Domains\Shared\Migration\MigrationAbstract as MigrationAbstractShared;
use App\Domains\SharedApp\Migration\DBAL\PointType;

abstract class MigrationAbstract extends MigrationAbstractShared
{
    /**
     * @return void
     */
    protected function defineTypePoint(): void
    {
        if (Type::hasType('point') === false) {
            Type::addType('point', PointType::class);
        }

        $this->db()
            ->getDoctrineSchemaManager()
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('point', 'point');
    }
}
