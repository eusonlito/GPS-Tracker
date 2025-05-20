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
}
