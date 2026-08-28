<?php declare(strict_types=1);

namespace App\Domains\ExpenseCategory\Action;

class Delete extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->check();
        $this->delete();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkSystem();
        $this->checkGlobal();
        $this->checkInUse();
    }

    /**
     * @return void
     */
    protected function checkSystem(): void
    {
        if ($this->row->isSystem()) {
            $this->exceptionValidator(__('expense-category-update.error.system-delete'));
        }
    }

    /**
     * @return void
     */
    protected function checkGlobal(): void
    {
        if (empty($this->row->isGlobal())) {
            return;
        }

        if ($this->auth->admin === false) {
            $this->exceptionValidator(__('expense-category-update.error.system-admin'));
        }
    }

    /**
     * @return void
     */
    protected function checkInUse(): void
    {
        if ($this->row->expenses()->exists()) {
            $this->exceptionValidator(__('expense-category-update.error.in-use'));
        }
    }

    /**
     * @return void
     */
    protected function delete(): void
    {
        $this->row->delete();
    }
}
