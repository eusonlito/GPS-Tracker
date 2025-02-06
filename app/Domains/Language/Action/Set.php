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
        if ($this->defined()) {
            return;
        }

        $this->row();
        $this->set();
    }

    /**
     * @return bool
     */
    protected function defined(): bool
    {
        return app()->bound('language')
            && (app()->getLocale() === app('language')->locale);
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row ??= $this->rowDefault()
            ?: $this->rowFirst();
    }

    /**
     * @return ?\App\Domains\Language\Model\Language
     */
    protected function rowDefault(): ?Model
    {
        return Model::query()
            ->selectSession()
            ->whereDefault()
            ->first();
    }

    /**
     * @return ?\App\Domains\Language\Model\Language
     */
    protected function rowFirst(): ?Model
    {
        return Model::query()
            ->selectSession()
            ->orderByFirst()
            ->first();
    }

    /**
     * @return void
     */
    protected function set(): void
    {
        if (empty($this->row)) {
            return;
        }

        $this->setSystem();
        $this->setConfig();
        $this->setLocale();
        $this->setBind();
        $this->setSession();
    }

    /**
     * @return void
     */
    protected function setSystem(): void
    {
        setlocale(LC_COLLATE, $this->row->locale);
        setlocale(LC_CTYPE, $this->row->locale);
        setlocale(LC_MONETARY, $this->row->locale);
        setlocale(LC_TIME, $this->row->locale);

        if (defined('LC_MESSAGES')) {
            setlocale(LC_MESSAGES, $this->row->locale);
        }
    }

    /**
     * @return void
     */
    protected function setConfig(): void
    {
        config(['app.locale' => $this->row->locale]);
    }

    /**
     * @return void
     */
    protected function setLocale(): void
    {
        app()->setLocale($this->row->locale);
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
        if ($this->request?->hasSession()) {
            $this->request->session()->put('language_id', $this->row->id);
        }
    }
}
