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
     * @var string
     */
    protected string $driver;

    /**
     * @var array
     */
    protected array $queue = [];

    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    protected function db(): ConnectionInterface
    {
        return $this->db ??= DB::connection();
    }

    /**
     * @return string
     */
    protected function driver(): string
    {
        return $this->driver ??= $this->db()->getDriverName();
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
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function dateTimeCreatedAt(Blueprint $table): ColumnDefinition
    {
        return $table->dateTimeTz('created_at')->useCurrent();
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function dateTimeUpdatedAt(Blueprint $table): ColumnDefinition
    {
        $definition = $table->dateTimeTz('updated_at')->useCurrent()->useCurrentOnUpdate();

        if ($this->driver() === 'pgsql') {
            $this->dateTimeUpdatedAtTrigger($table->getTable());
        }

        return $definition;
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    protected function dateTimeDeletedAt(Blueprint $table): ColumnDefinition
    {
        return $table->dateTimeTz('deleted_at')->nullable();
    }

    /**
     * @param string $table
     *
     * @return void
     */
    protected function dateTimeUpdatedAtTrigger(string $table): void
    {
        $this->queueAdd($this->database()->dropTriggerUpdatedAt($table, false));
        $this->queueAdd($this->database()->createTriggerUpdatedAt($table, false));
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     *
     * @return \Illuminate\Database\Schema\ForeignKeyDefinition
     */
    protected function foreign(Blueprint $table, string $remote, ?string $alias = null): ForeignKeyDefinition
    {
        $name = ($alias ?: $remote.'_id');
        $column = $alias ?: $remote;

        if ($this->driver() === 'pgsql') {
            $table->index($name, $this->indexName($table, $column, 'id_index'));
        }

        return $table->foreign($name, $this->indexName($table, $column, 'fk'))
            ->references('id')
            ->on($remote);
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     *
     * @return \Illuminate\Database\Schema\ForeignKeyDefinition
     */
    protected function foreignOnDeleteSetNull(Blueprint $table, string $remote, ?string $alias = null): ForeignKeyDefinition
    {
        return $this->foreign($table, $remote, $alias)->onDelete('SET NULL');
    }

    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     * @param string $remote
     * @param ?string $alias = null
     *
     * @return \Illuminate\Database\Schema\ForeignKeyDefinition
     */
    protected function foreignOnDeleteCascade(Blueprint $table, string $remote, ?string $alias = null): ForeignKeyDefinition
    {
        return $this->foreign($table, $remote, $alias)->onDelete('CASCADE');
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
     * @return array
     */
    protected function getTables(): array
    {
        $tables = $this->db()->getDoctrineSchemaManager()->listTableNames();

        return array_filter($tables, static fn ($table) => $table !== 'migrations');
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
        return $this->db()->getDoctrineSchemaManager()->listTableDetails($table)->hasIndex($this->indexName($table, $name, $suffix));
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
            $this->db()->getDoctrineSchemaManager()->listTableForeignKeys($table),
            static fn ($foreign) => $foreign->getName() === $index
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

    /**
     * @param string $sql
     *
     * @return void
     */
    protected function queueAdd(string $sql): void
    {
        $this->queue[] = $sql;
    }

    /**
     * @return void
     */
    protected function queue(): void
    {
        $db = $this->db();

        foreach ($this->queue as $sql) {
            $db->statement($sql);
        }

        $this->queue = [];
    }

    /**
     * @return void
     */
    public function upFinish(): void
    {
        $this->queue();
    }
}
