<?php declare(strict_types=1);

namespace App\Services\Protocol\GT06\Parser;

use App\Services\Protocol\ParserAbstract;

class Auth extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        $this->values = [];

        if ($this->bodyIsValid() === false) {
            return [];
        }

        $this->addIfValid($this->resourceAuth());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function bodyIsValid(): bool
    {
        return (bool)preg_match($this->bodyIsValidRegExp(), $this->body, $this->values);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/^'
            .'(7878)'        // 1 - start
            .'([0-9a-f]{2})' // 2 - length
            .'(01)'          // 3 - protocol
            .'([0-9]{16})'   // 4 - serial
            .'([0-9]{4})'    // 5 - type
            .'([0-9]{4})'    // 6 - timezone
            .'([0-9a-f]{4})' // 7 - serial information
            .'([0-9a-f]{4})' // 8 - error check
            .'$/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->values[4];
    }

    /**
     * @return array
     */
    protected function data(): array
    {
        return ['serial' => $this->serial()];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return "\x78\x78\x05\x01\x00\x01\xD9\xDC\x0D\x0A";
    }
}
