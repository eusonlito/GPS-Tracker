<?php declare(strict_types=1);

namespace App\Domains\Language\Action;

use App\Domains\Language\Model\Language as Model;

class Request extends ActionAbstract
{
    /**
     * @var string
     */
    protected string $acceptLanguage;

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->acceptLanguage();
        $this->row();
        $this->set();
    }

    /**
     * @return void
     */
    protected function acceptLanguage(): void
    {
        $this->acceptLanguage = strval($this->request->header('Accept-Language'));
    }

    /**
     * @return void
     */
    protected function row(): void
    {
        $this->row = $this->rowSession()
            ?: $this->rowLocale()
            ?: $this->rowCode()
            ?: $this->rowDefault()
            ?: $this->rowFirst();
    }

    /**
     * @return ?\App\Domains\Language\Model\Language
     */
    protected function rowSession(): ?Model
    {
        if ($this->request->hasSession() === false) {
            return null;
        }

        if (empty($id = $this->request->session()->get('language_id'))) {
            return null;
        }

        return Model::query()->byId($id)->first();
    }

    /**
     * @return ?\App\Domains\Language\Model\Language
     */
    protected function rowLocale(): ?Model
    {
        if (empty($locale = $this->rowLocaleValue())) {
            return null;
        }

        return Model::query()
            ->selectSession()
            ->byLocale($locale)
            ->first();
    }

    /**
     * @return ?string
     */
    protected function rowLocaleValue(): ?string
    {
        return preg_match('/^[a-z]+\-[A-Z]+/', $this->acceptLanguage, $matches)
            ? str_replace('-', '_', $matches[0])
            : null;
    }

    /**
     * @return ?\App\Domains\Language\Model\Language
     */
    protected function rowCode(): ?Model
    {
        return Model::query()
            ->selectSession()
            ->byLocaleCode($this->rowCodeValue())
            ->first();
    }

    /**
     * @return string
     */
    protected function rowCodeValue(): string
    {
        return preg_match('/^[a-zA-Z]+/', $this->acceptLanguage, $matches)
            ? $matches[0]
            : explode('_', config('app.locale'))[0];
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
     * @return \App\Domains\Language\Model\Language
     */
    protected function rowFirst(): Model
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
        $this->factory()->action()->set();
    }
}
