<?php declare(strict_types=1);

namespace App\Domains\Core\Model\Traits;

trait TranslationSimple
{
    use JsonColumn;

    /**
     * @param ?string $key = null
     * @param mixed $default = null
     *
     * @return mixed
     */
    public function translation(?string $key = null, mixed $default = null): mixed
    {
        return $this->jsonColumn('translation', $key, $default);
    }
}
