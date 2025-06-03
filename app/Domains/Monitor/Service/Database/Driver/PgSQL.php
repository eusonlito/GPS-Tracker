<?php declare(strict_types=1);

namespace App\Domains\Monitor\Service\Database\Driver;

class PgSQL extends DriverAbstract
{
    /**
     * @return array
     */
    public function size(): array
    {
        return $this->db()->select('
            SELECT
                "table_name",
                ROUND(("data_length" + "index_length") / 1024 / 1024, 2) AS "total_size",
                ROUND("data_length" / 1024 / 1024, 2) AS "table_size",
                ROUND("index_length" / 1024 / 1024, 2) AS "index_size"
            FROM
                (
                    SELECT
                        "table_name",
                        pg_total_relation_size(quote_ident("table_schema") || \'.\' || quote_ident("table_name")) AS "data_length",
                        pg_relation_size(quote_ident("table_schema") || \'.\' || quote_ident("table_name")) AS "index_length"
                    FROM
                        "information_schema"."tables"
                    WHERE
                        "table_catalog" = :table_catalog
                        AND "table_schema" = \'public\'
                        AND "table_type" = \'BASE TABLE\'
                ) AS "sizes"
            ORDER BY
                ("data_length" + "index_length") DESC;
        ', ['table_catalog' => $this->config('database')]);
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

        foreach ($this->getTables() as $table) {
            $sql[] = '(SELECT COUNT(*) FROM "'.$table['schema'].'"."'.$table['name'].'") AS "'.$table['name'].'"';
        }

        return 'SELECT '.implode(', ', $sql).';';
    }
}
