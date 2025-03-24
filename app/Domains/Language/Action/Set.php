<?php declare(strict_types=1);

namespace App\Domains\Language\Action;

use App\Domains\Language\Model\Language as Model;

class Set extends ActionAbstract
{
    /**
     * @var string
     */
    protected string $locale;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->locale();

        if ($this->available() === false) {
            return;
        }

        if ($this->defined()) {
            return;
        }

        $this->row();
        $this->set();
    }

    /**
     * @return void
     */
    protected function locale(): void
    {
        $this->locale = config('app.locale');

        if (str_contains($this->locale, '_')) {
            return;
        }

        $this->locale = match ($this->locale) {
            'en' => 'en_US',
            'pt' => 'pt_BR',
            'he' => 'he_IL',
            'ar' => 'ar_AE',
            default => $this->locale.'_'.strtoupper($this->locale),
        };

        trigger_error(sprintf('Please, configure APP_LOCALE as "%s"', $this->locale), E_USER_DEPRECATED);

        config(['app.locale' => $this->locale]);
    }

    /**
     * @return bool
     */
    protected function available(): bool
    {
        return app('configuration')->available();
    }

    /**
     * @return bool
     */
    protected function defined(): bool
    {
        return app()->bound('language')
            && ($this->locale === app('language')->locale);
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
            ->byLocale($this->locale)
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
