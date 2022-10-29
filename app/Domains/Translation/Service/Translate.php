<?php declare(strict_types=1);

namespace App\Domains\Translation\Service;

use App\Exceptions\UnexpectedValueException;
use App\Services\Translator\TranslatorFactory;

class Translate extends ServiceAbstract
{
    /**
     * @var string
     */
    protected string $base = 'resources/lang';

    /**
     * @param string $from
     * @param string $to
     *
     * @return self
     */
    public function __construct(protected string $from, protected string $to)
    {
        if ($this->from === $this->to) {
            throw new UnexpectedValueException('Languages must be different');
        }

        $this->base = base_path($this->base);
    }

    /**
     * @return void
     */
    public function write(): void
    {
        foreach ($this->files() as $file) {
            $this->translate($file);
        }
    }

    /**
     * @return array
     */
    protected function files(): array
    {
        return glob($this->base.'/'.$this->from.'/*.php');
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function file(string $name): string
    {
        return $this->base.'/'.$this->to.'/'.$name;
    }

    /**
     * @param string $from
     *
     * @return void
     */
    protected function translate(string $from): void
    {
        $file = $this->file(basename($from));
        $current = array_dot(is_file($file) ? (require $file) : []);
        $empty = helper()->arrayFilterRecursive($current, static fn ($value) => is_string($value) && empty($value));
        $strings = array_filter(array_intersect_key(array_dot(require $from), $empty));

        if (empty($strings)) {
            return;
        }

        $this->writeFile($file, $this->translateUndot($current, $strings));
    }

    /**
     * @param array $current
     * @param array $strings
     *
     * @return array
     */
    protected function translateUndot(array $current, array $strings): array
    {
        return $this->undot(array_merge($current, array_combine(array_keys($strings), $this->request($strings))));
    }

    /**
     * @param array $strings
     *
     * @return array
     */
    protected function request(array $strings): array
    {
        return TranslatorFactory::get()->array($this->from, $this->to, $strings);
    }
}
