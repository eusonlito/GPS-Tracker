<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Model\Traits;

trait TranslationSimple
{
    use JsonColumn;

    /**
     * @param ?string $key = null
     * @param mixed $default = null
     *
     * @return mixed
     */
    public function translation(?string $key = null, $default = null)
    {
        return $this->jsonColumn('translation', $key, $default);
    }
}
