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
    public function updatedAtNow(): void
    {
        $this->updatedAtNowFunction();
        $this->updatedAtNowTrigger();
    }

    /**
     * @return void
     */
    protected function updatedAtNowFunction(): void
    {
        $this->db->unprepared(trim(<<<'EOF'

        CREATE OR REPLACE FUNCTION "updated_at_now"()
        RETURNS TRIGGER AS $$
        BEGIN
            NEW."updated_at" = NOW();
            RETURN NEW;
        END;
        $$ LANGUAGE plpgsql;

        EOF));
    }

    /**
     * @return void
     */
    protected function updatedAtNowTrigger(): void
    {
        $this->db->unprepared(trim(<<<'EOF'

        DO $$
        DECLARE
            "tbl" RECORD;
        BEGIN
            FOR "tbl" IN
                SELECT "table_schema", "table_name"
                FROM "information_schema"."columns"
                WHERE (
                    "column_name" = 'updated_at'
                    AND "table_schema" = 'public'
                )
            LOOP
                EXECUTE format(
                    'CREATE OR REPLACE TRIGGER "updated_at_now_trigger" BEFORE UPDATE ON %I.%I FOR EACH ROW EXECUTE FUNCTION "updated_at_now"();',
                    "tbl"."table_schema",
                    "tbl"."table_name"
                );
            END LOOP;
        END;
        $$;

        EOF));
    }
}
