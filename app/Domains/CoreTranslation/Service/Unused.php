<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Service;

use Exception;

class Unused extends ServiceAbstract
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

        return $this->clean();
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
     * @return self
     */
    protected function clean(): self
    {
        foreach (config('app.locales') as $lang) {
            $this->cleanLanguage($lang);
        }

        return $this;
    }

    /**
     * @param string $lang
     *
     * @return void
     */
    protected function cleanLanguage(string $lang): void
    {
        foreach (glob(base_path('resources/lang/'.$lang.'/*.php')) as $file) {
            $this->cleanLanguageFile($file);
        }
    }

    /**
     * @param string $file
     *
     * @return void
     */
    protected function cleanLanguageFile(string $file): void
    {
        $code = str_replace('.php', '', basename($file));

        if (empty($this->list[$code])) {
            unlink($file);
        }
    }
}
