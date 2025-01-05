<?php declare(strict_types=1);

namespace App\Services\Protocol\GPS103\Parser;

use App\Services\Protocol\ParserAbstract;

class Heartbeat extends ParserAbstract
{
    /**
     * @return array
     */
    public function resources(): array
    {
        if ($this->messageIsValid() === false) {
            return [];
        }

        $this->values = explode(',', $this->message);

        $this->addIfValid($this->resourceHeartbeat());

        return $this->resources;
    }

    /**
     * @return bool
     */
    public function messageIsValid(): bool
    {
        return (bool)preg_match($this->messageIsValidRegExp(), $this->message);
    }

    /**
     * @return string
     */
    protected function messageIsValidRegExp(): string
    {
        return '/^'
            .'[0-9]+' // 0 - serial
            .'$/';
    }

    /**
     * @return string
     */
    protected function serial(): string
    {
        return $this->values[0];
    }

    /**
     * @return string
     */
    protected function response(): string
    {
        return 'ON';
    }
}
