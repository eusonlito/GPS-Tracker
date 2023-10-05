<?php declare(strict_types=1);

namespace App\Domains\Core\Migration\Database;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

abstract class DatabaseAbstract
{
    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    abstract public function uuid(Blueprint $table): ColumnDefinition;

    /**
     * @return void
     */
    abstract public function functionUpdatedAtNow(): void;

    /**
     * @param string $table
     * @param bool $execute = false
     *
     * @return string
     */
    abstract public function dropTriggerUpdatedAt(string $table, bool $execute = false): string;

    /**
     * @param string $table
     * @param bool $execute = false
     *
     * @return string
     */
    abstract public function createTriggerUpdatedAt(string $table, bool $execute = false): string;

    /**
     * @param \Illuminate\Database\ConnectionInterface $db
     *
     * @return self
     */
    public function __construct(protected ConnectionInterface $db)
    {
    }
}
