<?php declare(strict_types=1);

namespace App\Domains\User\Action;

class Set extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->set();
    }

    /**
     * @return void
     */
    protected function set(): void
    {
        $this->setRow();
        $this->setLanguage();
    }

    /**
     * @return void
     */
    protected function setRow(): void
    {
        app()->bind('user', fn () => $this->row);
    }

    /**
     * @return void
     */
    protected function setLanguage(): void
    {
        $this->factory('Language', $this->row->language)->action()->set();
    }
}
