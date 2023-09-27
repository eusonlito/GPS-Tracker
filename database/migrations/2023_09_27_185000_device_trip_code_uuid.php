<?php declare(strict_types=1);

use App\Domains\CoreApp\Migration\MigrationAbstract;

return new class extends MigrationAbstract {
    /**
     * @return void
     */
    public function up()
    {
        $this->update();
        $this->upFinish();
    }

    /**
     * @return void
     */
    protected function update()
    {
        $this->db()->statement('
            UPDATE `trip`
            SET `code` = (SELECT UUID())
            WHERE `code` IS NULL;
        ');

        $this->db()->statement('
            UPDATE `device`
            SET `code` = (SELECT UUID())
            WHERE `code` IS NULL;
        ');
    }
};
