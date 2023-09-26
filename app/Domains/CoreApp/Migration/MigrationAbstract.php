<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Migration;

use Doctrine\DBAL\Types\Type;
use App\Domains\Core\Migration\MigrationAbstract as MigrationAbstractCore;
use App\Domains\CoreApp\Migration\DBAL\PointType;

abstract class MigrationAbstract extends MigrationAbstractCore
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
