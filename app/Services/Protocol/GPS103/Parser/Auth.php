<?php declare(strict_types=1);

namespace App\Services\Protocol\GPS103\Parser;

use App\Services\Protocol\ParserAbstract;

class Auth extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        if ($this->bodyIsValid() === false) {
            return [];
        }

        $this->values = explode(',', $this->body);

        $this->addIfValid($this->resourceAuth());

        return $this->resources;
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
