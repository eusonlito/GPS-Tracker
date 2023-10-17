<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Service;

use Exception;

class Clean extends ServiceAbstract
{
    /**
     * @var array
     */
    protected array $list = [];

    /**
     * @return self
     */
    public function write(): self
    {
        $this->scan();

        return $this->fill(array_map('array_unique', $this->list));
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function file(string $file): void
    {
        preg_match_all('/(__|trans_choice)\([\'"]([^\'"]+)/', file_get_contents($file), $matches);

        foreach ($matches[2] as $string) {
            if (str_contains($string, '.') === false) {
                throw new Exception(sprintf('Invalid string %s on file %s', $string, $this->fileRelative($file)));
            }

            [$file, $code] = explode('.', $string, 2);

            $this->list[$file][] = $code;
        }
    }

    /**
     * @param array $default
     *
     * @return self
     */
    protected function fill(array $default): self
    {
        foreach (config('app.locales') as $lang) {
            $this->fillLanguage($lang, $default);
        }

        return $this;
    }

    /**
     * @param string $lang
     * @param array $default
     *
     * @return void
     */
    protected function fillLanguage(string $lang, array $default): void
    {
        foreach ($default as $file => $keys) {
            $this->fillLanguageFile($lang, $file, $keys);
        }
    }

    /**
     * @param string $lang
     * @param string $file
     * @param array $keys
     *
     * @return void
     */
    protected function fillLanguageFile(string $lang, string $file, array $keys): void
    {
        $file = base_path('resources/lang/'.$lang.'/'.$file.'.php');

        if (!is_file($file)) {
            return;
        }

        $current = array_dot(require $file);
        $remove = array_diff(array_keys($current), $keys);

        $this->writeFile($file, $this->undot(array_diff_key($current, array_flip($remove))));
    }
}
