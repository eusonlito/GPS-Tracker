<?php declare(strict_types=1);

namespace App\Domains\MaintenanceItem\Action;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        if (config('demo.enabled')) {
            $this->exceptionValidator(__('demo.error.not-allowed'));
        }

        $this->delete();
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->row->delete();
    }
}
