<?php declare(strict_types=1);

namespace App\Domains\Translation\Service;

class Only extends ServiceAbstract
{
    /**
     * @var string
     */
    protected string $lang = '';

    /**
     * @var string
     */
    protected string $base = 'resources/lang';

    /**
     * @param string $lang
     *
     * @return self
     */
    public function __construct(string $lang)
    {
        $this->lang = $lang;
        $this->base = base_path($this->base);
    }

    /**
     * @return array
     */
    public function scan(): array
    {
        $status = [];
        $langs = $this->langs();

        foreach ($this->files() as $file) {
            if ($matches = $this->check($file, $langs)) {
                array_push($status, ...$matches);
            }
        }

        return $status;
    }

    /**
     * @return array
     */
    protected function langs(): array
    {
        return array_diff(array_map('basename', glob($this->base.'/*', GLOB_ONLYDIR)), [$this->lang]);
    }

    /**
     * @return array
     */
    protected function files(): array
    {
        return glob($this->base.'/'.$this->lang.'/*.php');
    }

    /**
     * @param string $lang
     * @param string $name
     *
     * @return ?array
     */
    protected function file(string $lang, string $name): ?array
    {
        $file = $this->base.'/'.$lang.'/'.$name;

        return is_file($file) ? (require $file) : null;
    }

    /**
     * @param string $file
     * @param array $langs
     *
     * @return array
     */
    protected function check(string $file, array $langs): array
    {
        $status = [];
        $keys = array_dot(array_keys(require $file));
        $name = basename($file);

        foreach ($langs as $lang) {
            $status[] = $this->checkLang($lang, $name, $keys);
        }

        return $status;
    }

    /**
     * @param string $lang
     * @param string $name
     * @param array $keys
     *
     * @return ?string
     */
    protected function checkLang(string $lang, string $name, array $keys): ?string
    {
        if (empty($current = $this->file($lang, $name))) {
            return sprintf('File %s not exists for language "%s"', $name, $lang);
        }

        if ($diff = array_diff($keys, array_dot(array_keys($current)))) {
            return sprintf('This keys do not exists on "%s" (%s): %s', $lang, $name, implode(', ', $diff));
        }

        $current = array_dot(array_keys(array_filter($current)));

        if ($current) {
            return sprintf('This keys are empty on "%s" (%s): %s', $lang, $name, implode(', ', $current));
        }

        return null;
    }
}
