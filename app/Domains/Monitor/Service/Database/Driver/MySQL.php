<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Database\Driver;

use Illuminate\Support\Facades\DB;

class MySQL extends DriverAbstract
{
    /**
     * @return array
     */
    public function size(): array
    {
        if (isset($this->cache[__FUNCTION__])) {
            return $this->cache[__FUNCTION__];
        }

        $this->analyze();

        return $this->cache[__FUNCTION__] = DB::select('
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
        ', ['table_schema' => $this->config('database')]);
    }

    /**
     * @return array
     */
    public function count(): array
    {
        return $this->cache[__FUNCTION__] ??= (array)$this->db()->select($this->countSql())[0];
    }

    /**
     * @return string
     */
    protected function countSql(): string
    {
        $sql = [];

        foreach ($this->tables() as $table) {
            $sql[] = '(SELECT COUNT(*) FROM `'.$table.'`) AS `'.$table.'`';
        }

        return 'SELECT '.implode(', ', $sql).';';
    }

    /**
     * @return void
     */
    protected function analyze(): void
    {
        $this->db()->statement('ANALYZE LOCAL TABLE `'.implode('`, `', $this->tables()).'`;');
    }
}
