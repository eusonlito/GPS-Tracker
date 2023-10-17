<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Service;

class PlainExport extends ServiceAbstract
{
    /**
     * @var string
     */
    protected string $base = 'resources/lang';

    /**
     * @param string $lang
     *
     * @return self
     */
    public function __construct(protected string $lang)
    {
        $this->base = base_path($this->base);
    }

    /**
     * @return string
     */
    public function generate(): string
    {
        $list = [];

        foreach ($this->files() as $file) {
            $list += $this->contents($file);
        }

        return $this->toString($list);
    }

    /**
     * @return array
     */
    protected function files(): array
    {
        return glob($this->base.'/'.$this->lang.'/*.php');
    }

    /**
     * @param string $file
     *
     * @return array
     */
    protected function contents(string $file): array
    {
        $name = str_replace('.php', '', basename($file));
        $values = [];

        foreach (array_dot(require $file) as $key => $value) {
            $values[$name.'.'.$key] = $value;
        }

        return $values;
    }

    /**
     * @param array $lines
     *
     * @return string
     */
    protected function toString(array $lines): string
    {
        return helper()->jsonEncode($lines);
    }
}
