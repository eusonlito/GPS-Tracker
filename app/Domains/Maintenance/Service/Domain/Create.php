<?php declare(strict_types=1);

namespace App\Domains\Maintenance\Service\Domain;

use App\Exceptions\ValidatorException;
use App\Services\Filesystem\Directory;
use App\Services\Filesystem\File;

class Create
{
    /**
     * @const
     */
    public const SECTIONS = ['Action', 'Command', 'Controller', 'Fractal', 'Mail', 'Middleware', 'Model', 'Schedule', 'Seeder', 'Validate'];

    /**
     * @var string
     */
    protected string $base;

    /**
     * @var string
     */
    protected string $target;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $table;

    /**
     * @param string $domain
     * @param string $section
     *
     * @return self
     */
    public function __construct(protected string $domain, protected string $section)
    {
        $this->check();
        $this->config();
    }

    /**
     * @return void
     */
    protected function check(): void
    {
        $this->checkName();
        $this->checkSection();
    }

    /**
     * @return void
     */
    protected function checkName(): void
    {
        if (preg_match('/^[A-Z][a-zA-Z0-9]+$/', $this->domain) === 0) {
            throw new ValidatorException(sprintf('Invalid domain name %s', $this->domain));
        }
    }

    /**
     * @return void
     */
    protected function checkSection(): void
    {
        if (in_array($this->section, static::SECTIONS) === false) {
            throw new ValidatorException(sprintf('Invalid section %s', $this->section));
        }
    }

    /**
     * @return void
     */
    protected function config(): void
    {
        $this->base = __DIR__.'/stub';
        $this->target = app_path('Domains/'.$this->domain);
        $this->name = snake_case($this->domain, '-');
        $this->table = snake_case($this->domain, '_');
    }

    /**
     * @return void
     */
    public function copy(): void
    {
        foreach (Directory::files($this->base.'/'.$this->section) as $file) {
            $this->file($file);
        }
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function file(string $file): void
    {
        $target = $this->fileTarget($file);

        if (is_file($target) === false) {
            File::write($target, $this->fileContents($file));
        }
    }

    /**
     * @param string $file
     *
     * @return string
     */
    protected function fileTarget(string $file): string
    {
        return $this->target.preg_replace('/\.stub$/', '.php', $this->replace(str_replace($this->base, '', $file)));
    }

    /**
     * @param string $file
     *
     * @return string
     */
    protected function fileContents(string $file): string
    {
        return $this->replace(file_get_contents($file));
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function replace(string $string): string
    {
        return strtr($string, [
            '{{ domain }}' => $this->domain,
            '__domain__' => $this->domain,
            '{{ name }}' => $this->name,
            '__name__' => $this->name,
            '{{ table }}' => $this->table,
            '__table__' => $this->table,
        ]);
    }
}
