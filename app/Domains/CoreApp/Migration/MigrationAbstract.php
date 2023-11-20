<?php declare(strict_types=1);

namespace App\Domains\CoreApp\Migration;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\StringType;
use App\Domains\Core\Migration\MigrationAbstract as MigrationAbstractCore;
use App\Domains\Core\Migration\DBAL\PointType;

abstract class MigrationAbstract extends MigrationAbstractCore
{
    /**
     * @return void
     */
    protected function defineTypeEnum(): void
    {
        if (Type::hasType('enum') === false) {
            Type::addType('enum', StringType::class);
        }

        $this->db()
            ->getDoctrineSchemaManager()
            ->getDatabasePlatform()
            ->registerDoctrineTypeMapping('enum', 'string');
    }

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
