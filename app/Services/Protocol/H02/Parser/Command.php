<?php declare(strict_types=1);

namespace App\Services\Protocol\H02\Parser;

use App\Services\Protocol\Resource\Command as CommandResource;

class Command extends ParserAbstract
{
    /**
     * @return ?\App\Services\Protocol\Resource\Command
     */
    public function resource(): ?CommandResource
    {
        if ($this->bodyIsValid() === false) {
            return null;
        }

        $this->values = explode(',', substr($this->body, 1, -1));

        return new CommandResource([
            'body' => $this->body,
            'maker' => $this->maker(),
            'serial' => $this->serial(),
            'type' => $this->type(),
            'payload' => $this->payload(),
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
        return $this->cache[__FUNCTION__] ??= explode(',', $this->values[3]);
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return '*'.$this->maker().','.$this->serial().',V4,'.$this->type().','.date('YmdHis').'#';
    }
}
