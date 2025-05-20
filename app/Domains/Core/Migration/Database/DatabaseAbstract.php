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
     * @param \Illuminate\Database\ConnectionInterface $db
     *
     * @return void
     */
    public function __construct(protected ConnectionInterface $db)
    {
    }

    /**
     * @return void
     */
    public function updatedAtNow(): void
    {
    }
}
