<?php declare(strict_types=1);

namespace App\Services\Protocol\H02\Parser;

use App\Services\Protocol\ParserAbstract;

class Command extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        if ($this->bodyIsValid() === false) {
            return [];
        }

        $this->values = explode(',', substr($this->body, 1, -1));

        $this->addIfValid($this->resourceCommand());

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
        return '/^'
            .'\*[A-Z]{2},' // 0 - maker
            .'[0-9]+,'     // 1 - serial
            .'V4,'         // 2 - type
            .'.*'          // 3 - payload
            .'$/';
    }

    /**
     * @return string
     */
    protected function maker(): string
    {
        return $this->values[0];
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->values[1];
    }

    /**
     * @return string
     */
    protected function type(): string
    {
        return $this->values[2];
    }

    /**
     * @return array
     */
    protected function payload(): array
    {
        return explode(',', $this->values[3]);
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return '*'.$this->maker().','.$this->serial().',V4,'.$this->type().','.date('YmdHis').'#';
    }
}
