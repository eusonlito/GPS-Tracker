<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Action;

use Illuminate\Support\Facades\DB;

class MigrationClean extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach (DB::table('migrations')->pluck('migration') as $each) {
            $this->check($each);
        }
    }

    /**
     * @param string $migration
     *
     * @return void
     */
    protected function check(string $migration): void
    {
        if (is_file($this->file($migration)) === false) {
            DB::table('migrations')->where('migration', $migration)->delete();
        }
    }

    /**
     * @param string $migration
     *
     * @return string
     */
    protected function file(string $migration): string
    {
        return base_path('database/migrations/'.$migration.'.php');
    }
}
