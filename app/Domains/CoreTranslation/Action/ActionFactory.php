<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Action;

use App\Domains\Core\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @return void
     */
    public function clean(): void
    {
        $this->actionHandle(Clean::class);
    }

    /**
     * @return void
     */
    public function fill(): void
    {
        $this->actionHandle(Fill::class);
    }

    /**
     * @return void
     */
    public function fix(): void
    {
        $this->actionHandle(Fix::class);
    }

    /**
     * @return array
     */
    public function fixed(): array
    {
        return $this->actionHandle(Fixed::class, $this->validate()->fixed());
    }

    /**
     * @return array
     */
    public function notTranslated(): array
    {
        return $this->actionHandle(NotTranslated::class);
    }

    /**
     * @return array
     */
    public function only(): array
    {
        return $this->actionHandle(Only::class, $this->validate()->only());
    }

    /**
     * @return string
     */
    public function plainExport(): string
    {
        return $this->actionHandle(PlainExport::class, $this->validate()->plainExport());
    }

    /**
     * @return void
     */
    public function plainImport(): void
    {
        $this->actionHandle(PlainImport::class, $this->validate()->plainImport());
    }

    /**
     * @return void
     */
    public function translate(): void
    {
        $this->actionHandle(Translate::class, $this->validate()->translate());
    }

    /**
     * @return void
     */
    public function unused(): void
    {
        $this->actionHandle(Unused::class);
    }
}
