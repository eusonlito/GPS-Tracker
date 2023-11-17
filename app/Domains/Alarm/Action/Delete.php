<?php declare(strict_types=1);

namespace App\Domains\Alarm\Action;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        if (config('demo.enabled') && ($this->row?->user_id === 1)) {
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
