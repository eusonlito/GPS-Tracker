<?php declare(strict_types=1);

namespace App\Services\Protocol\GT06\Parser;

use App\Services\Protocol\Resource\Auth as AuthResource;

class Auth extends ParserAbstract
{
    /**
     * @return ?\App\Services\Protocol\Resource\Auth
     */
    public function resource(): ?AuthResource
    {
        $this->values = [];

        if ($this->bodyIsValid() === false) {
            return null;
        }

        return new AuthResource([
            'body' => $this->body,
            'serial' => $this->serial(),
            'response' => $this->response(),
        ]);
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
            .'([0-9]{2})'    // 1 - length
            .'(01)'          // 2 - protocol
            .'([0-9]{16})'   // 3 - serial
            .'([0-9]{4})'    // 4 - type
            .'([0-9]{4})'    // 5 - timezone
            .'([0-9a-f]{4})' // 6 - serial information
            .'([0-9a-f]{4})' // 7 - error check
            .'(0d0a)'        // 8 - stop
            .'$/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->values[3];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return hex2bin(
            '7878'
            .$this->values[1]
            .$this->values[2]
            .$this->values[6]
            .$this->values[7]
            .$this->values[8]
        );
    }
}
