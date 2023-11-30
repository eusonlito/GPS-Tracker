<?php declare(strict_types=1);

namespace App\Domains\Language\Action;

use App\Domains\Language\Model\Language as Model;

class Set extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->row();
        $this->set();
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row ??= Model::query()
            ->selectSession()
            ->whereDefault()
            ->first();
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
