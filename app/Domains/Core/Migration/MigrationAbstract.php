<?php declare(strict_types=1);

namespace App\Domains\Core\Migration;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Database\Schema\ForeignKeyDefinition;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Domains\Core\Migration\Database\DatabaseAbstract;
use App\Domains\Core\Migration\Database\DatabaseFactory;

abstract class MigrationAbstract extends Migration
{
    /**
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected ConnectionInterface $db;

    /**
     * @var \App\Domains\Core\Migration\Database\DatabaseAbstract
     */
    protected DatabaseAbstract $database;

    /**
     * @var array
     */
    protected array $config;

    /**
     * @param string $key
     *
     * @return string|int
     */
    protected function config(string $key): string|int
    {
        $this->config ??= config('database.connections.'.config('database.default'));

        return $this->config[$key];
    }

    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    protected function db(): ConnectionInterface
    {
        return $this->db ??= DB::connection();
    }

    /**
     * @return \App\Domains\Core\Migration\Database\DatabaseAbstract
     */
    protected function database(): DatabaseAbstract
    {
        return $this->database ??= DatabaseFactory::get($this->db());
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function uuid(Blueprint $table): ColumnDefinition
    {
        return $this->database()->uuid($table);
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return void
     */
    protected function timestamps(Blueprint $table): void
    {
        $this->dateTimeCreatedAt($table);
        $this->dateTimeUpdatedAt($table);
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return void
     */
    protected function timestampsWithDelete(Blueprint $table): void
    {
        $this->timestamps($table);
        $this->dateTimeDeletedAt($table);
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function dateTimeCreatedAt(Blueprint $table): ColumnDefinition
    {
        return $table->dateTime('created_at')->useCurrent();
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function dateTimeUpdatedAt(Blueprint $table): ColumnDefinition
    {
        return $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function dateTimeDeletedAt(Blueprint $table): ColumnDefinition
    {
        return $table->dateTime('deleted_at')->nullable();
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     * @param ?string $reference = null
     *
     * @return \Illuminate\Database\Schema\ForeignKeyDefinition
     */
    protected function foreign(Blueprint $table, string $remote, ?string $alias = null, ?string $reference = null): ForeignKeyDefinition
    {
        $name = ($alias ?: ($remote.'_id'));
        $column = $alias ?: $remote;

        if ($this->config('driver') === 'pgsql') {
            $table->index($name, $this->indexName($table, preg_replace('/_id$/', '', $column), 'id_index'));
        }

        return $table->foreign($name, $this->indexName($table, $column, 'fk'))
            ->references($reference ?: 'id')
            ->on($remote);
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     * @param ?string $reference = null
     *
     * @return \Illuminate\Database\Schema\ForeignKeyDefinition
     */
    protected function foreignOnDeleteSetNull(Blueprint $table, string $remote, ?string $alias = null, ?string $reference = null): ForeignKeyDefinition
    {
        return $this->foreign($table, $remote, $alias, $reference)->onDelete('SET NULL');
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     * @param ?string $reference = null
     *
     * @return \Illuminate\Database\Schema\ForeignKeyDefinition
     */
    protected function foreignOnDeleteCascade(Blueprint $table, string $remote, ?string $alias = null, ?string $reference = null): ForeignKeyDefinition
    {
        return $this->foreign($table, $remote, $alias, $reference)->onDelete('CASCADE');
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint|string $table
     * @param string|array $columns
     * @param ?string $sufix = null
     *
     * @return string
     */
    protected function indexName(Blueprint|string $table, $columns, ?string $sufix = null): string
    {
        $table = strtolower(is_string($table) ? $table : $table->getTable());
        $columns = array_map('strtolower', (array)$columns);
        $sufix = trim(strtolower($sufix ?: 'index'), '_');
        $index = $table.'_'.implode('_', $columns).'_'.$sufix;

        for ($i = 1; strlen($index) >= 64; $i++) {
            $index = $this->indexNameCut($table, $columns, $sufix, $i);
        }

        return $index;
    }

    /**
     * @param string $table
     * @param array $columns
     * @param string $sufix
     * @param int $i
     *
     * @return string
     */
    protected function indexNameCut(string $table, array $columns, string $sufix, int $i): string
    {
        return substr($table, 0, -$i)
            .'_'.implode('_', array_map(static fn ($value) => substr($value, 0, -$i), $columns))
            .'_'.$sufix;
    }

    /**
     * @param array $tables = []
     *
     * @return void
     */
    protected function drop(array $tables = []): void
    {
        foreach (($tables ?: $this->getTables()) as $table) {
            Schema::dropIfExists($table);
        }
    }

    /**
     * @param string $table
     * @param string $column
     *
     * @return void
     */
    protected function dropColumnIfExists(string $table, string $column): void
    {
        if (Schema::hasColumn($table, $column)) {
            Schema::table($table, static fn (Blueprint $table) => $table->dropColumn($column));
        }
    }

    /**
     * @return array
     */
    protected function getTables(): array
    {
        return array_filter(
            array_column(Schema::getTables(schema: $this->getTablesSchema()), 'name'),
            static fn ($table) => $table !== 'migrations'
        );
    }

    /**
     * @return string
     */
    protected function getTablesSchema(): string
    {
        return $this->config($this->config('driver') === 'pgsql' ? 'search_path': 'database');
    }

    /**
     * @param string $table
     * @param string|array $name
     * @param ?string $suffix = null
     *
     * @return bool
     */
    protected function tableHasIndex(string $table, string|array $name, ?string $suffix = null): bool
    {
        return Schema::hasIndex($table, $this->indexName($table, $name, $suffix));
    }

    /**
     * @param string $table
     * @param string|array $name
     * @param ?string $suffix = null
     *
     * @return bool
     */
    protected function tableHasForeign(string $table, string|array $name, ?string $suffix = null): bool
    {
        $index = $this->indexName($table, $name, $suffix);

        return boolval(array_filter(
            Schema::getForeignKeys($table),
            static fn ($foreign) => $foreign['name'] === $index
        ));
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string|array $name
     * @param ?string $suffix = null
     *
     * @return void
     */
    protected function tableAddIndex(Blueprint $table, string|array $name, ?string $suffix = null): void
    {
        if ($this->tableHasIndex($table->getTable(), $name, $suffix) === false) {
            $table->index((array)$name, $this->indexName($table, $name, $suffix));
        }
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string|array $name
     * @param ?string $suffix = null
     *
     * @return void
     */
    protected function tableAddUnique(Blueprint $table, string|array $name, ?string $suffix = null): void
    {
        if ($this->tableHasIndex($table->getTable(), $name, $suffix ?: '_unique') === false) {
            $table->unique((array)$name, $this->indexName($table, $name, $suffix ?: 'unique'));
        }
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string|array $name
     * @param ?string $suffix = null
     *
     * @return void
     */
    protected function tableDropIndex(Blueprint $table, string|array $name, ?string $suffix = null): void
    {
        if ($this->tableHasIndex($table->getTable(), $name, $suffix)) {
            $table->dropIndex($this->indexName($table, $name, $suffix));
        }
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string|array $name
     * @param ?string $suffix = null
     *
     * @return void
     */
    protected function tableDropForeign(Blueprint $table, string|array $name, ?string $suffix = null): void
    {
        if ($this->tableHasIndex($table->getTable(), $name, $suffix)) {
            $table->dropForeign($this->indexName($table, $name, $suffix));
        }
    }
}
