<?php declare(strict_types=1);

namespace App\Domains\Shared\Validate;

interface ValidateInterface
{
    /**
     * @param array $data
     *
     * @return self
     */
    public function __construct(array $data);

    /**
     * @return array
     */
    public function handle(): array;
}
