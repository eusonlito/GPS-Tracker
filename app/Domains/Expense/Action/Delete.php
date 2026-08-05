<?php declare(strict_types=1);

namespace App\Domains\Expense\Action;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->check();
        $this->delete();
        $this->files();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if ($this->row->isRelated()) {
            $this->exceptionValidator(__('expense-update.error.related'));
        }
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->row->delete();
    }

    /**
     * @return void
     */
    protected function files(): void
    {
        foreach ($this->row->files as $file) {
            $this->factory('File', $file)->action()->delete();
        }
    }
}
