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
        DB::statement('ANALYZE TABLE `'.implode('`, `', array_column($this->tables(), 'table_name')).'`;');
    }

    /**
     * @return array
     */
    protected function tables(): array
    {
        return DB::select('
            SELECT `table_name` AS `table_name`
            FROM `information_schema`.`tables`
            WHERE `table_schema` = :table_schema;
        ', ['table_schema' => $this->dbname()]);
    }

    /**
     * @return array
     */
    public function data(): array
    {
        return [
            'sizes' => $this->sizes(),
        ];
    }

    /**
     * @return array
     */
    protected function sizes(): array
    {
        return DB::select('
            SELECT
                `table_name` AS `table_name`,
                ROUND((`data_length` + `index_length`) / 1024 / 1024, 2) AS `total_size`,
                ROUND(`data_length` / 1024 / 1024, 2) AS `table_size`,
                ROUND(`index_length` / 1024 / 1024, 2) AS `index_size`,
                `table_rows` AS `table_rows`
            FROM
                `information_schema`.`TABLES`
            WHERE
                `table_schema` = :table_schema
            ORDER BY
                (`data_length` + `index_length`) DESC;
        ', ['table_schema' => $this->dbname()]);
    }

    /**
     * @return string
     */
    protected function dbname(): string
    {
        return config('database.connections.mysql.database');
    }
}
