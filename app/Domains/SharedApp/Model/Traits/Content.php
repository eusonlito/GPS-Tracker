<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Model\Traits;

trait Content
{
    use JsonColumn;

    /**
     * @param string $key
     * @param mixed $default = null
     *
     * @return mixed
     */
    public function content(string $key, mixed $default = null): mixed
    {
        return $this->jsonColumn('content', $key, $default);
    }
}
