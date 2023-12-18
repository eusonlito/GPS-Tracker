<?php declare(strict_types=1);

namespace App\Services\Protocol\GPS103\Parser;

use App\Services\Protocol\Resource\Auth as AuthResource;

class Auth extends ParserAbstract
{
    /**
     * @return ?\App\Services\Protocol\Resource\Auth
     */
    public function resource(): ?AuthResource
    {
        if ($this->bodyIsValid() === false) {
            return null;
        }

        $this->values = explode(',', $this->body);

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
        return (bool)preg_match($this->bodyIsValidRegExp(), $this->body);
    }

    /**
     * @return string
     */
    protected function bodyIsValidRegExp(): string
    {
        return '/^\#\#,'
            .'imei:[0-9]+,' // 1 - serial
            .'A'            // 2 - type
            .'$/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return explode(':', $this->values[1])[1];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return 'LOAD';
    }
}
