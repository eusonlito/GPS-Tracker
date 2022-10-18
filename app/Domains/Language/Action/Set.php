<?php declare(strict_types=1);

namespace App\Domains\Language\Action;

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
        $this->setLocale();
        $this->setBind();
        $this->setSession();
    }

    /**
     * @return void
     */
    protected function setLocale(): void
    {
        app()->setLocale($this->row->code);
    }

    /**
     * @return void
     */
    protected function setBind(): void
    {
        app()->bind('language', fn () => $this->row);
    }

    /**
     * @return void
     */
    protected function setSession(): void
    {
        if ($this->request->hasSession()) {
            $this->request->session()->put('language_id', $this->row->id);
        }
    }
}
