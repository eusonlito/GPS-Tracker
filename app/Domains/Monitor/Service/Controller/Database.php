<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Controller;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class Database extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Contracts\Auth\Authenticatable $auth
     *
     * @return self
     */
    public function __construct(protected Request $request, protected Authenticatable $auth)
    {
        $this->analyze();
    }

    /**
     * @return void
     */
    protected function analyze(): void
    {
        DB::statement('ANALYZE LOCAL TABLE `'.implode('`, `', $this->tables()).'`;');
    }

    /**
     * @return array
     */
    protected function tables(): array
    {
        static $cache;

        return $cache ??= array_column(
            DB::select($this->tablesSql(), ['table_schema' => $this->dbname()]),
            'table_name'
        );
    }

    /**
     * @return string
     */
    protected function tablesSql(): string
    {
        return '
            SELECT `TABLE_NAME` AS `table_name`
            FROM `information_schema`.`TABLES`
            WHERE `TABLE_SCHEMA` = :table_schema;
        ';
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'sizes' => $this->sizes(),
            'counts' => $this->counts(),
        ];
    }

    /**
     * @return array
     */
    protected function sizes(): array
    {
        return DB::select('
            SELECT
                `TABLE_NAME` AS `table_name`,
                ROUND((`DATA_LENGTH` + `INDEX_LENGTH`) / 1024 / 1024, 2) AS `total_size`,
                ROUND(`DATA_LENGTH` / 1024 / 1024, 2) AS `table_size`,
                ROUND(`INDEX_LENGTH` / 1024 / 1024, 2) AS `index_size`
            FROM
                `information_schema`.`TABLES`
            WHERE
                `TABLE_SCHEMA` = :table_schema
            ORDER BY
                (`DATA_LENGTH` + `INDEX_LENGTH`) DESC;
        ', ['table_schema' => $this->dbname()]);
    }

    /**
     * @return array
     */
    protected function counts(): array
    {
        return (array)DB::select($this->countsSql())[0];
    }

    /**
     * @return string
     */
    protected function countsSql(): string
    {
        $sql = [];

        foreach ($this->tables() as $table) {
            $sql[] = '(SELECT COUNT(*) FROM `'.$table.'`) AS `'.$table.'`';
        }

        return 'SELECT '.implode(', ', $sql).';';
    }

    /**
     * @return string
     */
    protected function dbname(): string
    {
        return config('database.connections.mysql.database');
    }
}
