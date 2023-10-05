<?php declare(strict_types=1);

namespace App\Domains\Core\Migration\Database;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

class SQLite extends DatabaseAbstract
{
    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function uuid(Blueprint $table): ColumnDefinition
    {
        return $table->uuid('uuid')->unique();
    }

    /**
     * @return void
     */
    public function functionUpdatedAtNow(): void
    {
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $table
     * @param bool $execute = false
     *
     * @return string
     */
    public function dropTriggerUpdatedAt(string $table, bool $execute = false): string
    {
        return '';
    }

    /**
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     *
     * @param string $table
     * @param bool $execute = false
     *
     * @return string
     */
    public function createTriggerUpdatedAt(string $table, bool $execute = false): string
    {
        return '';
    }
}
