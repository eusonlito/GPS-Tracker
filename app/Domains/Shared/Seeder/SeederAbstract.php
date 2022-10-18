<?php declare(strict_types=1);

namespace App\Domains\Shared\Seeder;

use Closure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SeederAbstract extends Seeder
{
    /**
     * @param string $name
     *
     * @return string
     */
    protected function file(string $name): string
    {
        return $this->pathDataFromClass().'/'.$name;
    }

    /**
     * @return string
     */
    protected function pathDataFromClass(): string
    {
        return base_path(lcfirst(dirname(str_replace('\\', '/', get_called_class())))).'/data';
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function contents(string $name): string
    {
        return file_get_contents($this->file($name));
    }

    /**
     * @param string $name
     *
     * @return array
     */
    protected function json(string $name): array
    {
        return json_decode($this->contents($name.'.json'), true);
    }

    /**
     * @param \Closure $function
     *
     * @return void
     */
    protected function transaction(Closure $function)
    {
        DB::transaction(function () use ($function) {
            Schema::disableForeignKeyConstraints();

            $function();

            Schema::enableForeignKeyConstraints();
        });
    }

    /**
     * @param string ...$tables
     *
     * @return void
     */
    protected function truncate(string ...$tables)
    {
        Schema::disableForeignKeyConstraints();

        foreach ((array)$tables as $table) {
            DB::table($table)->truncate();
        }

        Schema::enableForeignKeyConstraints();
    }

    /**
     * @param string $model
     * @param array $rows
     * @param string $key
     * @param bool $timestamps = true
     *
     * @return void
     */
    protected function insertWithoutDuplicates(string $model, array $rows, string $key, bool $timestamps = true): void
    {
        $keys = $model::pluck($key)->toArray();

        foreach ($rows as $row) {
            if (in_array($row[$key], $keys) === false) {
                $model::insert($this->insertWithoutDuplicatesData($row, $timestamps));
            }
        }
    }

    /**
     * @param array $row
     * @param bool $timestamps = true
     *
     * @return array
     */
    protected function insertWithoutDuplicatesData(array $row, bool $timestamps = true): array
    {
        return array_map(static fn ($value) => is_array($value) ? json_encode($value) : $value, $row);
    }
}
