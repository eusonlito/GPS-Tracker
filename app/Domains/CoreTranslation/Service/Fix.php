<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Service;

class Fix extends ServiceAbstract
{
    /**
     * @var string
     */
    protected string $base = 'resources/lang';

    /**
     * @return self
     */
    public function __construct()
    {
        $this->base = base_path($this->base);
    }

    /**
     * @return void
     */
    public function write(): void
    {
        foreach ($this->langs() as $lang) {
            foreach ($this->files($lang) as $file) {
                $this->check($file);
            }
        }
    }

    /**
     * @return array
     */
    protected function langs(): array
    {
        return array_map('basename', glob($this->base.'/*', GLOB_ONLYDIR));
    }

    /**
     * @param string $lang
     *
     * @return array
     */
    protected function files(string $lang): array
    {
        return glob($this->base.'/'.$lang.'/*.php');
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function check(string $file): void
    {
        $this->writeFile($file, $this->filter(require $file));
    }

    /**
     * @param array $values
     *
     * @return array
     */
    protected function filter(array $values): array
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $values[$key] = $this->filter($value);
            } elseif ($key === $value) {
                $values[$key] = '';
            }
        }

        return $values;
    }
}
