<?php declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up(): void
    {
        if ($this->upMigrated()) {
            return;
        }

        $this->tables();
        $this->keys();
        $this->upFinish();
    }

    /**
     * @return bool
     */
    protected function upMigrated(): bool
    {
        return Schema::hasColumn('user_session', 'success') === false;
    }

    /**
     * @return void
     */
    protected function tables(): void
    {
        $this->db()->unprepared('
            INSERT INTO `user_fail` (`type`, `text`, `ip`, `created_at`, `updated_at`, `user_id`)
            (
                SELECT "user-auth-credentials", `auth`, `ip`, `created_at`, `updated_at`, `user_id`
                FROM `user_session`
                WHERE `success` = FALSE
            );
        ');

        $this->db()->unprepared('
            DELETE FROM `user_session`
            WHERE (
                `success` = FALSE
                OR `user_id` IS NULL
            );
        ');

        Schema::table('user_session', function (Blueprint $table) {
            $table->dropColumn('success');
            $table->dropForeign('user_session_user_fk');
        });

        Schema::table('user_session', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }

    /**
     * @return void
     */
    protected function keys(): void
    {
        Schema::table('user_session', function (Blueprint $table) {
            $this->foreignOnDeleteCascade($table, 'user');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table('user_session', function (Blueprint $table) {
            $table->boolean('success')->default(0);
            $table->dropForeign('user_session_user_fk');

            $table->unsignedBigInteger('user_id')->nullable()->change();
        });

        Schema::table('user_session', function (Blueprint $table) {
            $this->foreignOnDeleteSetNull($table, 'user');
        });
    }
};
