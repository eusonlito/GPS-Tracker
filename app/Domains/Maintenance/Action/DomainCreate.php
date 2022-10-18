<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Action;

use App\Domains\Maintenance\Service\Domain\Create as CreateService;

class DomainCreate extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->check();
        $this->iterate();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        if (preg_match('/^[A-Z][a-zA-Z0-9]+$/', $this->data['name']) === 0) {
            $this->exceptionValidator(sprintf('Invalid domain name %s', $this->data['name']));
        }
    }

    /**
     * @return void
     */
    protected function iterate(): void
    {
        foreach (CreateService::SECTIONS as $section) {
            $this->section($section);
        }
    }

    /**
     * @param string $section
     *
     * @return void
     */
    protected function section(string $section): void
    {
        if ($this->data[strtolower($section)] ?? false) {
            (new CreateService($this->data['name'], $section))->copy();
        }
    }
}
