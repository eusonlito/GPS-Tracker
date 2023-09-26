<?php declare(strict_types=1);

namespace App\Domains\CoreMaintenance\Service\Domain\Section;

abstract class SectionAbstract
{
    /**
     * @var string
     */
    protected string $base;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $table;

    /**
     * @return void
     */
    abstract public function handle(): void;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $domain
     *
     * @return self
     */
    public function __construct(protected string $domain)
    {
        $this->config();
    }

    /**
     * @return void
     */
    protected function config(): void
    {
        $this->base = app_path('Domains/'.$this->domain);
        $this->name = snake_case($this->domain, '-');
        $this->table = snake_case($this->domain, '_');
    }
}
