<?php declare(strict_types=1);

namespace App\Domains\CoreTranslation\Service;

class NotTranslated extends ServiceAbstract
{
    /**
     * @param string $file
     *
     * @return array
     */
    protected function file(string $file): array
    {
        preg_match_all('/(__|trans_choice)\([\'"]([^\'"]+)/', file_get_contents($file), $matches);

        $file = $this->fileRelative($file);
        $empty = [];

        foreach ($matches[2] as $string) {
            if ($string === __($string)) {
                $empty[$file][] = $string;
            }
        }

        return $empty;
    }
}
