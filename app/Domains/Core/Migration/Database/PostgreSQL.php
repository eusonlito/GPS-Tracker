<?php declare(strict_types=1);

namespace App\Domains\Core\Migration\Database;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;

class PostgreSQL extends DatabaseAbstract
{
    /**
     * @param \Illuminate\Database\Schema\Blueprint $table
     *
     * @return \Illuminate\Database\Schema\ColumnDefinition
     */
    public function uuid(Blueprint $table): ColumnDefinition
    {
        return $table->uuid('uuid')->unique()->default($this->db->raw('gen_random_uuid()'));
    }

    /**
     * @return void
     */
    public function functionUpdatedAtNow(): void
    {
        $this->db->unprepared('
            CREATE OR REPLACE FUNCTION updated_at_now()
            RETURNS TRIGGER AS $$
            BEGIN
                NEW."updated_at" = now();
                RETURN NEW;
            END;
            $$ language \'plpgsql\';
        ');
    }

    /**
     * @param string $table
     * @param bool $execute = false
     *
     * @return string
     */
    public function dropTriggerUpdatedAt(string $table, bool $execute = false): string
    {
        $sql = '
            DROP TRIGGER IF EXISTS "update_'.$table.'_updated_at"
            ON "'.$table.'";
        ';

        if ($execute) {
            $this->db->unprepared($sql);
        }

        return $sql;
    }

    /**
     * @param string $table
     * @param bool $execute = false
     *
     * @return string
     */
    public function createTriggerUpdatedAt(string $table, bool $execute = false): string
    {
        $sql = '
            CREATE TRIGGER "update_'.$table.'_updated_at"
            BEFORE UPDATE ON "'.$table.'"
            FOR EACH ROW EXECUTE PROCEDURE updated_at_now();
        ';

        if ($execute) {
            $this->db->unprepared($sql);
        }

        return $sql;
    }
}
